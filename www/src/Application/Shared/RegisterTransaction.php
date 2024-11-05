<?php

namespace App\Application\Shared;

use App\Domain\Entities\Transaction;
use App\Domain\Enums\TransactionType;
use App\Domain\Ports\Out\BalanceRepositoryPort;
use App\Domain\Ports\Out\TransactionRepositoryPort;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;

class RegisterTransaction
{
    public function __construct(
        private readonly TransactionRepositoryPort $transactionRepositoryPort,
        private readonly BalanceRepositoryPort     $balanceRepositoryPort
    ) {
    }

    public function register(float $amount, Transaction $transaction): void
    {
        $balance = $this->balanceRepositoryPort->findByUserId($transaction->getUserId());

        if (
            $balance &&
            $transaction->getTransactionType() === TransactionType::EXPENSE->value &&
            abs($amount) > $balance->getBalance()
        ) {
            throw new BadRequestException('Transaction has exceeded balance.');
        }

        $saveTransaction = $this->transactionRepositoryPort->save($transaction);

        if (!$saveTransaction) {
            throw new BadRequestException('Transaction could not be saved.');
        }

        $finalAmount = $balance->getBalance() + $amount;

        $updateBalance = $this->balanceRepositoryPort->updateBalance($finalAmount, $transaction->getUserId());

        if (!$updateBalance) {
            throw new BadRequestException('Transaction could not be saved.');
        }
    }
}