<?php

namespace App\Domain\Ports\Out;

use App\Domain\Entities\Balance;
use App\Domain\Entities\Transaction;

interface BalanceRepositoryPort
{
    public function saveInitialBalance(Balance $balance): ?Balance;
    public function findByUserId(string $userId): ?Balance;
    public function updateBalance(Balance $balance): ?Balance;
}