<?php

namespace App\Application\UseCases\Users\AuthenticateUser;

use App\Application\DTOs\Users\AuthenticateUserDTO;

interface IAuthenticateUserUseCase
{
    public function execute(AuthenticateUserDTO $authenticateUserDTO): string;
}