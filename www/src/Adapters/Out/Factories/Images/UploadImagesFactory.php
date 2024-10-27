<?php

namespace App\Adapters\Out\Factories\Images;

use App\Adapters\Out\Services\DateAndTimeImplementation;
use App\Adapters\Out\Services\ImageQueueImplementation;
use App\Adapters\Out\Services\ImageStorageImplementation;
use App\Adapters\Out\Services\UuidGeneratorImplementation;
use App\Application\UseCases\Images\UploadImages\UploadImagesUseCase;
use App\Infrasctructure\Database\RedisDB;

class UploadImagesFactory
{
    public function init(): UploadImagesUseCase
    {
        $dateAndTimeImplementation   = new DateAndTimeImplementation();
        $uuidGeneratorImplementation = new UuidGeneratorImplementation();
        $imageQueueImplementation    = new ImageQueueImplementation(RedisDB::connect());
        $imageStorageImplementation  = new ImageStorageImplementation();
        
        return new UploadImagesUseCase(
            $dateAndTimeImplementation,
            $uuidGeneratorImplementation,
            $imageQueueImplementation,
            $imageStorageImplementation,
        );
    }
}