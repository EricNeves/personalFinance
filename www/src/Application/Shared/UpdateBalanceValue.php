<?php

namespace App\Application\Shared;

use App\Domain\Entities\Transaction;
use App\Domain\Enums\TransactionType;
use App\Domain\Ports\Out\BalanceRepositoryPort;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;

class UpdateBalanceValue
{
    public function __construct(private readonly BalanceRepositoryPort $balanceRepositoryPort)
    {
    }
    
    public function change(float $amount, Transaction $transaction): void
    {
        $balance = $this->balanceRepositoryPort->hasBalance($transaction);

        if (
            $balance &&
            $transaction->getTransactionType() === TransactionType::EXPENSE->value &&
            abs($amount) > $balance->getBalance()
        ) {
            throw new BadRequestException('Transaction has exceeded balance.');
        }

        if (!$balance && $transaction->getTransactionType() === TransactionType::INCOME->value) {
            $this->balanceRepositoryPort->save($transaction);
        }

        $updateBalance = $this->balanceRepositoryPort->updateBalance($amount, $transaction->getUserId());

        if (!$updateBalance) {
            throw new BadRequestException('Sorry, there was an error updating your balance.');
        }
    }
}