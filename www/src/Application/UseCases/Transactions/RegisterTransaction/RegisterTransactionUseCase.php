<?php

namespace App\Application\UseCases\Transactions\RegisterTransaction;

use App\Application\DTOs\Transactions\RegisterTransactionDTO;
use App\Application\Shared\TransactionTypeValidation;
use App\Application\Shared\UpdateBalanceValue;
use App\Domain\Entities\Balance;
use App\Domain\Entities\Transaction;
use App\Domain\Ports\Out\TransactionRepositoryPort;
use App\Domain\Services\DatabaseTransaction;
use App\Domain\Services\DateAndTime;
use App\Domain\Services\Uuid;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;

class RegisterTransactionUseCase implements IRegisterTransactionUseCase
{
    public function __construct(
        private readonly TransactionRepositoryPort $transactionRepositoryPort,
        private readonly DatabaseTransaction $databaseTransaction,
        private readonly UpdateBalanceValue $updateBalanceValue,
        private readonly TransactionTypeValidation $transactionTypeValidation,
        private readonly Uuid $uuid,
        private readonly DateAndTime $dateAndTime
    ) {
    }
    
    public function execute(RegisterTransactionDTO $registerTransactionDTO): Transaction
    {
        $currentDate = $this->dateAndTime->currentDateTime();
        $uuid        = $this->uuid->generateV4();

        $this->databaseTransaction->beginTransaction();

        $transactionType = $this->transactionTypeValidation->validate($registerTransactionDTO->getTransactionType());
        
        $transaction = new Transaction(
            $uuid,
            $registerTransactionDTO->getAmount(),
            $registerTransactionDTO->getDescription(),
            $transactionType->value,
            $currentDate,
            $registerTransactionDTO->getUserId()
        );
        
        $saveTransaction = $this->transactionRepositoryPort->save($transaction);
        
        if (!$saveTransaction) {
            throw new BadRequestException('Sorry, something went wrong while saving the transaction.');
        }

        $amountValue = $transactionType->isIncome() ? $transaction->getAmount() : -$transaction->getAmount();

        $this->updateBalanceValue->change($amountValue, $transaction);

        $this->databaseTransaction->commit();

        return $transaction;
    }
}