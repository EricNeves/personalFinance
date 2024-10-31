<?php

namespace App\Application\DTOs\Transactions;

class RegisterTransactionDTO
{
    public function __construct(
        private readonly float $amount,
        private readonly string $description,
        private readonly string $transactionType
    ) {
    }
    
    public function getAmount(): float
    {
        return $this->amount;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }
    
    public function getTransactionType(): string
    {
        return $this->transactionType;
    }
}