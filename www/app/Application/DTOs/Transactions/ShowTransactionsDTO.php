<?php

namespace App\Application\DTOs\Transactions;

class ShowTransactionsDTO
{
    public function __construct(
        private readonly string $userId,
        private readonly int $page = 1,
        private readonly int $perPage = 5
    ) {
    }
    
    public function getUserId(): string
    {
        return $this->userId;
    }
    
    public function getPage(): int
    {
        return $this->page;
    }
    
    public function getPerPage(): int
    {
        return $this->perPage;
    }
}