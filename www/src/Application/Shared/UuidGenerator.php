<?php

namespace App\Application\Shared;

use App\Domain\Services\Uuid;

readonly class UuidGenerator
{
    public function __construct(private readonly Uuid $uuid)
    {
    }
    
    public function generateV4(): string
    {
        return $this->uuid->generate_v4();
    }
}