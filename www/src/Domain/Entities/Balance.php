<?php

namespace App\Domain\Entities;

use JsonSerializable;

class Balance implements JsonSerializable
{
    public function __construct(private readonly float $balance, private readonly string $userId)
    {
    }

    public function getBalance(): float
    {
        return $this->balance;
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