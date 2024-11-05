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
        $balance =
    }
}