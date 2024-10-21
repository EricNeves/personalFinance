<?php

namespace App\Adapters\In\Web\Controllers\Users;

use App\Application\DTOs\Users\RegisterUserDTO;
use App\Application\UseCases\Users\RegisterUser\RegisterUserUseCase;
use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;

readonly class RegisterUserController
{
    public function __construct()
    {
    }
    
    public function handle(Request $request, Response $response): void
    {
        $body = $request->validate([
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        
        $response->json($body, 201);
    }
}