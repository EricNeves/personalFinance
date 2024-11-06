<?php

namespace App\Adapters\Out\Services;

use App\Domain\Services\Uuid;
use Ramsey\Uuid\Uuid as UuidLib;

class UuidGeneratorImplementation implements Uuid
{
    public function generateV4(): string
    {
        return UuidLib::uuid4()->toString();
    }
    
    public function isValid(string $uuid): bool
    {
        return UuidLib::isValid($uuid);
    }
}