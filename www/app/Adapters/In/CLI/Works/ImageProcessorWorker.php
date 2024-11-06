<?php

namespace App\Adapters\In\CLI\Works;

use App\Adapters\In\Jobs\ImageProcessorJob;
use App\Adapters\Out\Services\ImageQueueImplementation;
use App\Infrasctructure\Database\RedisDB;

class ImageProcessorWorker
{
    public static function run(): void
    {
        $imageQueueImplementation = new ImageQueueImplementation(RedisDB::connect());
        $imageProcessorJob        = new ImageProcessorJob($imageQueueImplementation);

        $imageProcessorJob->run('images');
    }
}