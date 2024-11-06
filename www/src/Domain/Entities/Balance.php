<?php

namespace App\Domain\Entities;

use JsonSerializable;

class Balance implements JsonSerializable
{
    public function __construct(
        private readonly ?string $id,
        private readonly float $balance,
        private readonly float $income,
        private readonly float $expense,
        private readonly string $userId
    ){
    }
    
    public function getId(): ?string
    {
        return $this->id;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }
    
    public function getIncome(): float
    {
        return $this->income;
    }
    
    public function getExpense(): float
    {
        return $this->expense;
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