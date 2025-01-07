<?php

namespace App\Adapters\Out\Services;

use App\Domain\Services\DatabaseTransaction;
use PDO;

class DatabaseTransactionImplementation implements DatabaseTransaction
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function beginTransaction(): void
    {
        if (!$this->pdo->inTransaction()) {
            $this->pdo->beginTransaction();
        }
    }

    public function commit(): void
    {
        if ($this->pdo->inTransaction()) {
            $this->pdo->commit();
        }
    }

    public function rollback(): void
    {
        if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
        }
    }

    public function isTransactionActive(): bool
    {
        return $this->pdo->inTransaction();
    }
}