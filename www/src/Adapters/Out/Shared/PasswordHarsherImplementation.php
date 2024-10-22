<?php

namespace App\Adapters\Out\Shared;

use App\Domain\Services\Harsher;

class PasswordHarsherImplementation implements Harsher
{
    public function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verify(string $password, string $hash): bool
    {
        if (!password_verify($password, $hash)) {
            return false;
        }

        return true;
    }
}