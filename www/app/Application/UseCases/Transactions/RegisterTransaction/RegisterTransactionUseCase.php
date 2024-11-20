<?php

namespace App\Application\UseCases\Transactions\RegisterTransaction;

use App\Application\DTOs\Transactions\RegisterTransactionDTO;
use App\Application\Services\Transaction\RegisterTransaction;
use App\Application\Shared\TransactionTypeValidation;
use App\Domain\Entities\Transaction;
use App\Domain\Ports\Out\BalanceRepositoryPort;
use App\Domain\Services\DatabaseTransaction;
use App\Domain\Services\DateAndTime;
use App\Domain\Services\Uuid;

class RegisterTransactionUseCase implements IRegisterTransactionUseCase
{
    public function __construct(
        private readonly DatabaseTransaction $databaseTransaction,
        private readonly RegisterTransaction $registerTransaction,
        private readonly TransactionTypeValidation $transactionTypeValidation,
        private readonly BalanceRepositoryPort $balanceRepositoryPort,
        private readonly Uuid $uuid,
        private readonly DateAndTime $dateAndTime
    ) {
    }
    
    public function execute(RegisterTransactionDTO $registerTransactionDTO): array
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

        $amountValue = $transactionType->isIncome() ? $transaction->getAmount() : -$transaction->getAmount();

        $this->registerTransaction->register($amountValue, $transactionType, $transaction);

        $this->databaseTransaction->commit();

        return [
            'transaction' => $transaction,
            'balance'     => $this->balanceRepositoryPort->findByUserId($registerTransactionDTO->getUserId())
        ];
    }
}