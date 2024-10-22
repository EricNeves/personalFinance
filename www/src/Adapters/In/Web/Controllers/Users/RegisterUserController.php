<?php

namespace App\Adapters\In\Web\Controllers\Users;

use App\Adapters\Out\Factories\Users\RegisterUserFactory;
use App\Application\DTOs\Users\RegisterUserDTO;
use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;

readonly class RegisterUserController
{
    public function __construct(private readonly RegisterUserFactory $registerUserFactory)
    {
    }
    
    public function handle(Request $request, Response $response): void
    {
        $body = $request->validate([
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $registerUserDTO = new RegisterUserDTO($body['name'], $body['email'], $body['password']);

        $registerUserUseCase = $this->registerUserFactory->init()->execute($registerUserDTO);

        $response->json(['data' => $registerUserUseCase],201);
    }
}