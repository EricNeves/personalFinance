<?php

namespace App\Domain\Ports\Out;

interface ImageStoragePort
{
    public function upload(string $path, string $tmpFile): void;
}