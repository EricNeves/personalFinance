<?php

namespace App\Application\Services\Transaction;

use App\Application\Shared\CalculateFinalValueBalance;
use App\Domain\Entities\Transaction;
use App\Domain\Enums\TransactionType;
use App\Domain\Ports\Out\BalanceRepositoryPort;
use App\Domain\Ports\Out\TransactionRepositoryPort;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;

class RegisterTransaction
{
    public function __construct(
        private readonly TransactionRepositoryPort $transactionRepositoryPort,
        private readonly BalanceRepositoryPort $balanceRepositoryPort,
        private readonly CalculateFinalValueBalance $calculateFinalValueTransaction
    ) {
    }
    
    public function register(float $amount, TransactionType $transactionType, Transaction $transaction): void
    {
        $balance = $this->balanceRepositoryPort->findByUserId($transaction->getUserId());
        
        if ($balance && $transactionType->isExpense() && abs($amount) > $balance->getBalance()) {
            throw new BadRequestException('Transaction has exceeded balance.');
        }
        
        $saveTransaction = $this->transactionRepositoryPort->save($transaction);
        
        if (!$saveTransaction) {
            throw new BadRequestException('Transaction could not be saved.');
        }
        
        $totalBalance = $this->calculateFinalValueTransaction->calculate(
            $balance->getBalance(),
            $balance->getIncome(),
            $balance->getExpense(),
            $amount,
            $transactionType,
            $transaction->getUserId()
        );
        
        $updateBalance = $this->balanceRepositoryPort->updateBalance($totalBalance);
        
        if (!$updateBalance) {
            throw new BadRequestException('Transaction could not be saved.');
        }
    }
}