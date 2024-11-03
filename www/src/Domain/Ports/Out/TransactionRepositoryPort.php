<?php

namespace App\Domain\Ports\Out;

use App\Domain\Entities\Balance;
use App\Domain\Entities\Transaction;

interface TransactionRepositoryPort
{
    public function save(Transaction $transaction): ?Transaction;
}