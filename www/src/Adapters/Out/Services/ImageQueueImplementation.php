<?php

namespace App\Adapters\Out\Services;

use App\Domain\Entities\Image;
use App\Domain\Services\ImageQueue;
use Redis;

class ImageQueueImplementation implements ImageQueue
{
    public function __construct(private readonly Redis $redis)
    {
    }
    
    public function dispatch(string $key, Image $image): void
    {
        $this->redis->lPush($key, json_encode($image));
    }
}