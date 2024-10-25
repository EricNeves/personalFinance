<?php

namespace App\Domain\Ports\Out;

use App\Domain\Entities\Image;

interface ImageRepositoryPort
{
    public function save(Image $image): bool;
}