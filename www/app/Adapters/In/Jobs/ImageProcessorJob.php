<?php

namespace App\Adapters\In\Jobs;

use App\Domain\Services\ImageQueue;
use Nette\Utils\Image;

class ImageProcessorJob
{
    public function __construct(private readonly ImageQueue $imageQueue)
    {
    }

    public function run(string $key): void
    {
        echo '[+] Worker started...'.PHP_EOL;

        while (true) {
            $queueData = $this->imageQueue->dequeue($key);

            if ($queueData) {
                $uploadDir = dirname(__DIR__, 4) . $queueData->getPathName();
                $targetDir = dirname(__DIR__, 4) . '/assets/uploads/' . $queueData->getPathName();

                $image = Image::fromFile($uploadDir);

                $image->resize($queueData->getWidth(), $queueData->getHeight());

                $image->save($targetDir);
                
                unlink($uploadDir);

                echo '[+] Worker finished...'.PHP_EOL;
            }
        }
    }
}