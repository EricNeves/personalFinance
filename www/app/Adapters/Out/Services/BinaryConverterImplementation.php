<?php

namespace App\Adapters\Out\Services;

use App\Domain\Services\BinaryConverter;

class BinaryConverterImplementation implements BinaryConverter
{
    public function toBase64(mixed $binary): string
    {
        return base64_encode($binary);
    }

    public function fromBase64(mixed $binary): string
    {
        return base64_decode($binary);
    }
}