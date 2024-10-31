<?php

namespace App\Application\Shared;

use App\Domain\Ports\Out\TransactionRepositoryPort;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;

class UpdateBalanceValue
{
    public function __construct(private readonly TransactionRepositoryPort $transactionRepositoryPort)
    {
    }
    
    public function update(float $amount, string $userId): void
    {
        $changeBalance = $this->transactionRepositoryPort->changeBalance($amount, $userId);
        
        if (!$changeBalance) {
            throw new BadRequestException('Something went wrong while updating balance.');
        }
    }
}