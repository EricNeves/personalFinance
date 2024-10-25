<?php

namespace App\Application\DTOs\Image;

class UploadImageDTO
{
    public function __construct(
        private readonly array $images,
        private readonly string $user_id
    ) {
    }
    
    public function getImages(): array
    {
        return $this->images;
    }
    public function getUserID(): string
    {
        return $this->user_id;
    }
}