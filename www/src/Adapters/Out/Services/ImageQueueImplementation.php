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

    public function dequeue(string $key): ?Image
    {
        $imageParsed = $this->redis->brPop($key, 10);

        if (!$imageParsed) {
            return null;
        }

        [$queueKey, $object] = $imageParsed;

        $image = json_decode($object, true);

        return new Image(
            $image['id'],
            $image['filename'],
            $image['pathName'],
            $image['mimeType'],
            $image['size'],
            $image['width'],
            $image['height'],
            $image['userID'],
            $image['createdAt'],
            $image['updatedAt']
        );
    }
}