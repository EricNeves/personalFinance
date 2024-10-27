<?php

namespace App\Application\DTOs\Image;

class UploadImageDTO
{
    public function __construct(
        private readonly array $images,
        private readonly int $width,
        private readonly int $height,
        private readonly string $user_id
    ) {
    }
    
    public function getImages(): array
    {
        return $this->images;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getUserID(): string
    {
        return $this->user_id;
    }
}