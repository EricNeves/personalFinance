<?php

namespace App\Adapters\Out\Shared;

use App\Domain\Services\Uuid;
use Ramsey\Uuid\Uuid as UuidLib;

class UuidGeneratorImplementation implements Uuid
{
    public function generate_v4(): string
    {
        return UuidLib::uuid4()->toString();
    }
}