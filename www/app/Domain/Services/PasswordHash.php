<?php

namespace App\Domain\Services;

interface  PasswordHash
{
    public function hash(string $password): string;
    public function verify(string $password, string $hash): bool;
}