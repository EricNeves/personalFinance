<?php

namespace App\Domain\Services;

interface  Harsher
{
    public function hash(string $password): string;
    public function verify(string $password, string $hash): bool;
}