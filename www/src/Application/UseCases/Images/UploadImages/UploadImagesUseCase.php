<?php

namespace App\Application\UseCases\Images\UploadImages;

use App\Application\DTOs\Image\UploadImageDTO;
use App\Domain\Entities\Image;
use App\Domain\Ports\Out\ImageStoragePort;
use App\Domain\Services\DateAndTime;
use App\Domain\Services\ImageQueue;
use App\Domain\Services\Uuid;

class UploadImagesUseCase implements IUploadImagesUseCase
{
    public function __construct
    (
        private readonly DateAndTime $dateAndTime,
        private readonly Uuid $uuid,
        private readonly ImageQueue $imageQueue,
        private readonly ImageStoragePort $imageStoragePort
    ) {
    }
    
    public function execute(UploadImageDTO $uploadImageDTO): string
    {
        foreach ($uploadImageDTO->getImages() as $image) {
            $currentDateTime = $this->dateAndTime->currentDateTime();
            $userID          = $uploadImageDTO->getUserID();
            $uniqueFilename  = $this->uuid->generateV4();
            $uuid            = $this->uuid->generateV4();
            
            $pathDir        = '/assets/uploads/';
            $pathName       = $pathDir . $uniqueFilename . $image['name'];
            
            $imageEntity = new Image(
                $uuid,
                $uniqueFilename,
                $pathName,
                $image['type'],
                $image['size'],
                $uploadImageDTO->getWidth(),
                $uploadImageDTO->getHeight(),
                $userID,
                $currentDateTime
            );

            $this->imageStoragePort->upload($pathName, $image['tmp_name']);
            
            $this->imageQueue->dispatch('images', $imageEntity);
        }
        
        return 'Images sent for processing.';
    }
}