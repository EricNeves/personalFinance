<?php

namespace App\Adapters\Out\Services;

use App\Domain\Services\DatabaseTransaction;
use PDO;

class DatabaseTransactionImplementation implements DatabaseTransaction
{
    private bool $transactionActive = false;

    public function __construct(private readonly PDO $pdo)
    {
    }

    public function beginTransaction(): void
    {
        if (!$this->transactionActive) {
            $this->transactionActive = true;
            $this->pdo->beginTransaction();
        }
    }

    public function commit(): void
    {
        if ($this->transactionActive) {
            $this->transactionActive = false;
            $this->pdo->commit();
        }
    }

    public function rollback(): void
    {
        if ($this->transactionActive) {
            $this->transactionActive = false;
            $this->pdo->commit();
        }
    }

    public function isTransactionActive(): bool
    {
        return $this->transactionActive;
    }
}