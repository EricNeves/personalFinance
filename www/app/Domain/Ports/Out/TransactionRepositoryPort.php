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
    public function allPaginated(string $userId, int $offset = 1, int $limit = 5): array;
    public function all(string $userId): array;
    public function count(string $userId): int;
}