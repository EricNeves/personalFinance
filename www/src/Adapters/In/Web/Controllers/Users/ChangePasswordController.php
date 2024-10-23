<?php

namespace App\Adapters\In\Web\Controllers\Users;

use App\Adapters\Out\Factories\Users\ChangePasswordFactory;
use App\Application\DTOs\Users\ChangePasswordDTO;
use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;

class ChangePasswordController
{
    public function __construct(private readonly ChangePasswordFactory $changePasswordFactory)
    {
    }
    
    public function handle(Request $request, Response $response): void
    {
        $fields = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
        ]);
        
        $changePasswordDTO = new ChangePasswordDTO($fields['old_password'], $fields['new_password'], $request->user()->id());
        
        $this->changePasswordFactory->init()->execute($changePasswordDTO);
        
        $response->json([
            'data' => "Password changed successfully.",
        ]);
    }
}