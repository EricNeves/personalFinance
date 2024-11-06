<?php

namespace App\Adapters\In\Web\Controllers\Users;

use App\Adapters\Out\Factories\Users\EditUserInformationFactory;
use App\Application\DTOs\Users\EditUserInformationDTO;
use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;

class EditUserController
{
    public function __construct(private readonly EditUserInformationFactory $editUserInformationFactory)
    {
    }
    
    public function handle(Request $request, Response $response): void
    {
        $fields = $request->validate(['name' => 'required']);
        
        $editUserInformationDTO = new EditUserInformationDTO($request->user()->id(), $fields['name']);
        
        $response->json([
            'data' => $this->editUserInformationFactory->init()->execute($editUserInformationDTO)
        ]);
    }
    
}