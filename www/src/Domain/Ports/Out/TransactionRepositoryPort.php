<?php

namespace App\Domain\Ports\Out;

use App\Domain\Entities\Transaction;

interface TransactionRepositoryPort
{
    public function save(Transaction $transaction): bool;
    public function changeBalance(float $amount, string $userId): bool;
}