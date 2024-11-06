<?php

namespace App\Domain\Ports\Out;

use App\Domain\Entities\Balance;
use App\Domain\Entities\Transaction;

interface TransactionRepositoryPort
{
    public function save(Transaction $transaction): ?Transaction;
    public function fetchTransactionForUser(string $transactionId, string $userId): ?Transaction;
    public function remove(string $transactionId, string $userId): ?Transaction;
    public function removeAllByUser(string $userId): void;
}