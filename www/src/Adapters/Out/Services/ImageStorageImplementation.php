<?php

namespace App\Adapters\Out\Services;

use App\Domain\Ports\Out\ImageStoragePort;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;

class ImageStorageImplementation implements ImageStoragePort
{
    public function upload(string $path, string $tmpFile): void
    {
        if (!is_uploaded_file($tmpFile)) {
            throw new BadRequestException('File uploaded is not valid.');
        }

        $pathToFile = dirname(__DIR__, 4) . $path;

        if (!move_uploaded_file($tmpFile, $pathToFile)) {
            throw new BadRequestException('File upload failed.');
        }
    }
}