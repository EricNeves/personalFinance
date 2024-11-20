<?php

namespace App\Application\UseCases\Users\AuthenticateUser;

use App\Application\DTOs\Users\AuthenticateUserDTO;
use App\Application\Services\User\CommonUserAuthenticationService;

class AuthenticateUserUseCase implements IAuthenticateUserUseCase
{
    public function __construct(
        private readonly CommonUserAuthenticationService $commonUserAuthenticationService
    ) {
    }
    
    public function execute(AuthenticateUserDTO $authenticateUserDTO): string
    {
        return $this->commonUserAuthenticationService->authenticate(
            $authenticateUserDTO->getEmail(),
            $authenticateUserDTO->getPassword()
        );
    }
}