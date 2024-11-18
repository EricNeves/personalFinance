<?php

namespace App\Domain\Entities;

class Report
{
    public function __construct(
        private readonly string $id,
        private readonly string $file,
        private readonly string $userId,
    ) {
    }
    
    public function getId(): string
    {
        return $this->id;
    }
    
    public function getFile(): string
    {
        return $this->file;
    }
    
    public function getUserId(): string
    {
        return $this->userId;
    }
}