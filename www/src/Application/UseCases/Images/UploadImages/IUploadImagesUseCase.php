<?php

namespace App\Application\UseCases\Images\UploadImages;

use App\Application\DTOs\Image\UploadImageDTO;

interface IUploadImagesUseCase
{
    public function execute(UploadImageDTO $uploadImageDTO): string;
}