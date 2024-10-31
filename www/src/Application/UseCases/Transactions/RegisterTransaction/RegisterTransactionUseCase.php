<?php

namespace App\Application\UseCases\Transactions\RegisterTransaction;

use App\Application\DTOs\Transactions\RegisterTransactionDTO;
use App\Application\Shared\UpdateBalanceValue;
use App\Domain\Entities\Transaction;
use App\Domain\Enums\TransactionType;
use App\Domain\Ports\Out\TransactionRepositoryPort;
use App\Domain\Services\DateAndTime;
use App\Domain\Services\Uuid;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;

class RegisterTransactionUseCase implements IRegisterTransactionUseCase
{
    public function __construct(
        private readonly TransactionRepositoryPort $transactionRepositoryPort,
        private readonly UpdateBalanceValue $updateBalanceValue,
        private readonly Uuid $uuid,
        private readonly DateAndTime $dateAndTime
    ) {
    }
    
    public function execute(RegisterTransactionDTO $registerTransactionDTO): Transaction
    {
        $currentDate = $this->dateAndTime->currentDateTime();
        $uuid        = $this->uuid->generateV4();
        
        $transactionType = TransactionType::from($registerTransactionDTO->getTransactionType());
        
        $transaction = new Transaction(
            $uuid,
            $registerTransactionDTO->getAmount(),
            $registerTransactionDTO->getDescription(),
            $transactionType,
            $currentDate,
            $registerTransactionDTO->getUserId()
        );
        
        $saveTransaction = $this->transactionRepositoryPort->save($transaction);
        
        if ($saveTransaction) {
            throw new BadRequestException('Sorry, something went wrong while saving the transaction.');
        }
        
        $balanceChange = $transactionType->isIncome() ? $transaction->getAmount() : -$transaction->getAmount();
        
        $this->updateBalanceValue->update($balanceChange, $transaction->getUserId());
        
        return $transaction;
    }
}