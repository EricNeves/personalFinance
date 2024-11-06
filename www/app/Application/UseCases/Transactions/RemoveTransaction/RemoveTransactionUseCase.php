<?php

namespace App\Application\UseCases\Transactions\RemoveTransaction;

use App\Application\DTOs\Transactions\RemoveTransactionDTO;
use App\Application\Shared\CalculateFinalValueBalance;
use App\Domain\Entities\Balance;
use App\Domain\Enums\TransactionType;
use App\Domain\Ports\Out\BalanceRepositoryPort;
use App\Domain\Ports\Out\TransactionRepositoryPort;
use App\Domain\Services\DatabaseTransaction;
use App\Domain\Services\Uuid;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;
use App\Infrasctructure\Exceptions\ApplicationErrors\NotFoundException;

class RemoveTransactionUseCase implements IRemoveTransactionUseCase
{
    public function __construct(
        private readonly BalanceRepositoryPort $balanceRepositoryPort,
        private readonly TransactionRepositoryPort $transactionRepositoryPort,
        private readonly DatabaseTransaction $databaseTransaction,
        private readonly CalculateFinalValueBalance $calculateFinalValueTransaction,
        private readonly Uuid $uuid
    ) {
    }
    
    public function execute(RemoveTransactionDTO $removeTransactionDTO): Balance
    {
        $this->databaseTransaction->beginTransaction();
        
        if (!$this->uuid->isValid($removeTransactionDTO->getTransactionId())) {
            throw new BadRequestException('Please enter a valid uuid.');
        }
        
        $balanceByUser = $this->balanceRepositoryPort->findByUserId($removeTransactionDTO->getUserId());
        
        if (!$balanceByUser) {
            throw new NotFoundException('Sorry, the transaction was not found.');
        }
        
        $removeTransaction = $this->transactionRepositoryPort->remove(
            $removeTransactionDTO->getTransactionId(),
            $removeTransactionDTO->getUserId()
        );
        
        if (!$removeTransaction) {
            throw new NotFoundException('Sorry, the transaction was not found.');
        }
        
        $balance = $balanceByUser->getBalance();
        $income  = $balanceByUser->getIncome();
        $expense = $balanceByUser->getExpense();
        
        if ($removeTransaction->getTransactionType() === TransactionType::INCOME->value) {
            if ($removeTransaction->getAmount() > $balance) {
                $balance = 0;
                $income  = 0;
                $expense = 0;
                
                $this->transactionRepositoryPort->removeAllByUser($removeTransactionDTO->getUserId());
            } else {
                $income  -= $removeTransaction->getAmount();
                $balance -= $removeTransaction->getAmount();
            }
        } else {
            $expense -= $removeTransaction->getAmount();
            $balance += $removeTransaction->getAmount();
        }
        
        $totalBalance = $this->calculateFinalValueTransaction->calculate(
            $balance,
            $income,
            $expense,
            0,
            TransactionType::from($removeTransaction->getTransactionType()),
            $removeTransaction->getUserId()
        );
        
        $updateBalance = $this->balanceRepositoryPort->updateBalance($totalBalance);
        
        if (!$updateBalance) {
            throw new BadRequestException('Sorry, we could not update the balance.');
        }
        
        $this->databaseTransaction->commit();
        
        return $this->balanceRepositoryPort->findByUserId($removeTransactionDTO->getUserId());
    }
}