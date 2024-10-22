<?php

namespace App\Application\Shared;

use App\Domain\Services\Harsher;

class PasswordHarsher
{
    public function __construct(private readonly Harsher $harsher)
    {
    }
    
    public function generateHash(string $password): string
    {
        return $this->harsher->hash($password);
    }
}