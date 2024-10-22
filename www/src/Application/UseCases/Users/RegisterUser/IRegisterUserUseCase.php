<?php

namespace App\Application\UseCases\Users\RegisterUser;

use App\Application\DTOs\Users\RegisterUserDTO;
use App\Domain\Entities\User;

interface IRegisterUserUseCase
{
    public function execute(RegisterUserDTO $registerUserDTO): User;
}