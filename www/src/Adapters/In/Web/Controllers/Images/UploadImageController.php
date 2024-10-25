<?php

namespace App\Adapters\In\Web\Controllers\Images;

use App\Adapters\Out\Factories\Images\UploadImagesFactory;
use App\Application\DTOs\Image\UploadImageDTO;
use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;

class UploadImageController
{
    public function __construct(private readonly UploadImagesFactory $uploadImagesFactory)
    {
    }
    
    public function handle(Request $request, Response $response): void
    {
        $fields = $request->validate(['images' => 'image']);
        
        $uploadImagesDTO = new UploadImageDTO($fields['images'], $request->user()->id());
        
        $uploadImages = $this->uploadImagesFactory->init()->execute($uploadImagesDTO);
        
        $response->json(['data' => $uploadImages], 201);
    }
}