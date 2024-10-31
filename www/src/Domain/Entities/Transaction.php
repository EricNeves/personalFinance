<?php

namespace App\Domain\Entities;

use App\Domain\Enums\TransactionType;
use JsonSerializable;

class Transaction implements JsonSerializable
{
    public function __construct(
        private readonly string $id,
        private readonly float $amount,
        private readonly string $description,
        private readonly TransactionType $transactionType,
        private readonly string $createdAt,
        private readonly string $userId
    ) {
    }
    
    public function getId(): string
    {
        return $this->id;
    }
    
    public function getAmount(): float
    {
        return $this->amount;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }
    
    public function getTransactionType(): TransactionType
    {
        return $this->transactionType;
    }
    
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
    
    public function getUserId(): string
    {
        return $this->userId;
    }
    
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
