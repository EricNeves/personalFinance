<?php

namespace App\Domain\Services;

interface DatabaseTransaction
{
    public function beginTransaction();
    public function isTransactionActive();
    public function commit();
    public function rollback();
}