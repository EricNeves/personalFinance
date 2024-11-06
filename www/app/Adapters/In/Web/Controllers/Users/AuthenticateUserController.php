<?php

namespace App\Adapters\In\Web\Controllers\Users;

use App\Adapters\Out\Factories\Users\AuthenticateUserFactory;
use App\Application\DTOs\Users\AuthenticateUserDTO;
use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;

class AuthenticateUserController
{
    public function __construct(private readonly AuthenticateUserFactory $authenticateUserFactory)
    {
    }
    
    public function handle(Request $request, Response $response): void
    {
        $fields = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);
        
        $authenticateUserDTO = new AuthenticateUserDTO($fields['email'], $fields['password']);
        
        $response->json([
            'data' => $this->authenticateUserFactory->init()->execute($authenticateUserDTO)
        ]);
    }
}