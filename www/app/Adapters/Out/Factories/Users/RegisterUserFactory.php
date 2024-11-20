<?php

namespace App\Adapters\Out\Factories\Users;

use App\Adapters\Out\Persistence\Repositories\BalancePostgresRepository;
use App\Adapters\Out\Persistence\Repositories\UserPostgresRepository;
use App\Adapters\Out\Services\DateAndTimeImplementation;
use App\Adapters\Out\Services\PasswordHashImplementation;
use App\Adapters\Out\Services\UuidGeneratorImplementation;
use App\Application\Services\Transaction\SaveInitialValueBalance;
use App\Application\Services\User\UserEmailAlreadyExists;
use App\Application\UseCases\Users\RegisterUser\RegisterUserUseCase;
use App\Infrasctructure\Database\Postgres;

class RegisterUserFactory
{
    public function init(): RegisterUserUseCase
    {
        $userPostgresRepository        = new UserPostgresRepository(Postgres::connect());
        $balancePostgresRepository     = new BalancePostgresRepository(Postgres::connect());
        $saveInitialValueBalance       = new SaveInitialValueBalance($balancePostgresRepository);
        $uuidGeneratorImplementation   = new UuidGeneratorImplementation();
        $passwordHarsherImplementation = new PasswordHashImplementation();
        $userEmailAlreadyExists        = new UserEmailAlreadyExists($userPostgresRepository);
        $dateAndTimeImplementation     = new DateAndTimeImplementation();

        return new RegisterUserUseCase(
            $userPostgresRepository,
            $userEmailAlreadyExists,
            $saveInitialValueBalance,
            $uuidGeneratorImplementation,
            $passwordHarsherImplementation,
            $dateAndTimeImplementation,
        );
    }
}