<?php

namespace App\Adapters\Out\Factories\Users;

use App\Adapters\Out\Persistence\Repositories\UserPostgresRepository;
use App\Adapters\Out\Services\DateAndTimeImplementation;
use App\Adapters\Out\Services\PasswordPasswordHashImplementation;
use App\Adapters\Out\Services\UuidGeneratorImplementation;
use App\Application\Shared\UserEmailAlreadyExists;
use App\Application\UseCases\Users\RegisterUser\RegisterUserUseCase;
use App\Infrasctructure\Database\Postgres;

class RegisterUserFactory
{
    public function init(): RegisterUserUseCase
    {
        $userPostgresRepository        = new UserPostgresRepository(Postgres::connect());
        $uuidGeneratorImplementation   = new UuidGeneratorImplementation();
        $passwordHarsherImplementation = new PasswordPasswordHashImplementation();
        $userEmailAlreadyExists        = new UserEmailAlreadyExists($userPostgresRepository);
        $dateAndTimeImplementation     = new DateAndTimeImplementation();

        return new RegisterUserUseCase(
            $userPostgresRepository,
            $userEmailAlreadyExists,
            $uuidGeneratorImplementation,
            $passwordHarsherImplementation,
            $dateAndTimeImplementation,
        );
    }
}