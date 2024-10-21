<?php

namespace App\Application\UseCases\Users\RegisterUser;

use App\Application\DTOs\Users\RegisterUserDTO;

interface IRegisterUserUseCase
{
    public function execute(RegisterUserDTO $registerUserDTO): void;
}