<?php

namespace App\Domain\Services;

interface DatabaseTransaction
{
    public function beginTransaction(): void;
    public function isTransactionActive(): bool;
    public function commit(): void;
    public function rollback(): void;
}