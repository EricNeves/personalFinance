<?php

namespace App\Adapters\Out\Factories\Users;

use App\Adapters\Out\Persistence\UserPostgresRepository;
use App\Adapters\Out\Shared\PasswordHarsherImplementation;
use App\Adapters\Out\Shared\UuidGeneratorImplementation;
use App\Application\Shared\PasswordHarsher;
use App\Application\Shared\UuidGenerator;
use App\Application\UseCases\Users\RegisterUser\RegisterUserUseCase;
use App\Infrasctructure\Database\Postgres;

class RegisterUserFactory
{
    public function init(): RegisterUserUseCase
    {
        $userPostgresRepository        = new UserPostgresRepository(Postgres::connect());
        $uuidGeneratorImplementation   = new UuidGeneratorImplementation();
        $uuidGenerator                 = new UuidGenerator($uuidGeneratorImplementation);
        $passwordHarsherImplementation = new PasswordHarsherImplementation();
        $passwordHarsher               = new PasswordHarsher($passwordHarsherImplementation);

        return new RegisterUserUseCase($userPostgresRepository, $uuidGenerator, $passwordHarsher);
    }
}