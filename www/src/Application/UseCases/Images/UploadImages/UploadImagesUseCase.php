<?php

namespace App\Application\UseCases\Images\UploadImages;

use App\Application\DTOs\Image\UploadImageDTO;
use App\Domain\Entities\Image;
use App\Domain\Services\DateAndTime;
use App\Domain\Services\ImageQueue;
use App\Domain\Services\Uuid;

class UploadImagesUseCase implements IUploadImagesUseCase
{
    public function __construct
    (
        private readonly DateAndTime $dateAndTime,
        private readonly Uuid $uuid,
        private readonly ImageQueue $imageQueue
    ) {
    }
    
    public function execute(UploadImageDTO $uploadImageDTO): string
    {
        foreach ($uploadImageDTO->getImages() as $image) {
            $currentDateTime = $this->dateAndTime->currentDateTime();
            $userID          = $uploadImageDTO->getUserID();
            $uniqueFilename  = $this->uuid->generateV4();
            $uuid            = $this->uuid->generateV4();
            
            $pathDir        = '/assets/images/';
            
            $image = new Image(
                $uuid,
                $uniqueFilename,
                $image['tmp_name'],
                $pathDir,
                $image['type'],
                $image['size'],
                $userID,
                $currentDateTime
            );
            
            $this->imageQueue->dispatch('images', $image);
        }
        
        return "Images sent for processing.";
    }
}