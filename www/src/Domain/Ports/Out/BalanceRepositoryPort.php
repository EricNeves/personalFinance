<?php

namespace App\Domain\Ports\Out;

use App\Domain\Entities\Balance;
use App\Domain\Entities\Transaction;

interface BalanceRepositoryPort
{
    public function save(Transaction $transaction): bool;
    public function hasBalance(Transaction $transaction): ?Balance;
    public function updateBalance(float $amount, string $user_id): ?Balance;
}