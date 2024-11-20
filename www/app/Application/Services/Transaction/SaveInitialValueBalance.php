<?php

namespace App\Application\Services\Transaction;

use App\Domain\Entities\Balance;
use App\Domain\Ports\Out\BalanceRepositoryPort;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;

class SaveInitialValueBalance
{
    public function __construct(private readonly BalanceRepositoryPort $balanceRepositoryPort)
    {
    }

    public function register(Balance $balance): void
    {
        $registerBalance = $this->balanceRepositoryPort->saveInitialBalance($balance);

        if (!$registerBalance) {
            throw new BadRequestException('Sorry, there was an error saving your initial balance.');
        }
    }
}