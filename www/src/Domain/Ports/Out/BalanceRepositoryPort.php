<?php

namespace App\Domain\Ports\Out;

use App\Domain\Entities\Balance;
use App\Domain\Entities\Transaction;

interface BalanceRepositoryPort
{
    public function saveInitialBalance(float $amount, string $userId): ?Balance;
    public function findByUserId(string $userId): ?Balance;
    public function updateBalance(float $amount, string $user_id): ?Balance;
}