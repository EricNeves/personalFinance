<?php

namespace App\Domain\Entities;

use JsonSerializable;
use DateTime;

class Image implements JsonSerializable
{
    public function __construct(
        private readonly string $id,
        private readonly string $filename,
        private readonly string $tmpName,
        private readonly string $path,
        private readonly string $mimeType,
        private readonly int $size,
        private readonly string $userID,
        private readonly ?string $createdAt = null,
        private readonly ?string $updatedAt = null
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
    
    public function getTmpName(): string
    {
        return $this->tmpName;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }
    
    public function getUserID(): string
    {
        return $this->userID;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}