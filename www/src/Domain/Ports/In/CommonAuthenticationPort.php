<?php

namespace App\Domain\Ports\In;

interface CommonAuthenticationPort
{
    public function authenticate(string $email, string $password): string;
}