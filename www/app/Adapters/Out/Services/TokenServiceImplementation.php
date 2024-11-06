<?php

namespace App\Adapters\Out\Services;

use App\Domain\Ports\Out\TokenServicePort;
use App\Infrasctructure\Http\JWT;

class TokenServiceImplementation implements TokenServicePort
{
    public function sign(mixed $payload): string
    {
        return JWT::sign($payload);
    }
}