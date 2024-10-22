<?php

namespace App\Domain\Ports\Out;

interface TokenServicePort
{
    public function sign(mixed $payload): string;
}