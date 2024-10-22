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
}