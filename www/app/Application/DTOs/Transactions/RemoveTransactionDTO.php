<?php

namespace App\Application\DTOs\Transactions;

class RemoveTransactionDTO
{
    public function __construct(private readonly string $transactionId, private readonly string $userId)
    {
    }
    
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }
    
    public function getUserId(): string
    {
        return $this->userId;
    }
}