<?php

namespace App\Application\Services;

use App\Domain\Entities\Balance;
use App\Domain\Ports\Out\BalanceRepositoryPort;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;

class SaveInitialValueBalance
{
    public function __construct(private readonly BalanceRepositoryPort $balanceRepositoryPort)
    {
    }

    public function register(float $amount, string $userId): void
    {
        $registerBalance = $this->balanceRepositoryPort->saveInitialBalance($amount, $userId);

        if (!$registerBalance) {
            throw new BadRequestException('Sorry, there was an error saving your initial balance.');
        }
    }
}