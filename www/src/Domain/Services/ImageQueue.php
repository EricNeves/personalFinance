<?php

namespace App\Domain\Services;

use App\Domain\Entities\Image;

interface ImageQueue
{
    public function dispatch(string $key, Image $image): void;
    public function dequeue(string $key): ?Image;
}