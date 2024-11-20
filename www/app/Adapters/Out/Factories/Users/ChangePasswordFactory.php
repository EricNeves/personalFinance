<?php

namespace App\Adapters\Out\Factories\Users;

use App\Adapters\Out\Persistence\Repositories\UserPostgresRepository;
use App\Adapters\Out\Services\DateAndTimeImplementation;
use App\Adapters\Out\Services\PasswordHashImplementation;
use App\Application\Services\User\AuthenticatedUserInformation;
use App\Application\UseCases\Users\ChangePassword\ChangePasswordUseCase;
use App\Infrasctructure\Database\Postgres;

class ChangePasswordFactory
{
    public function init(): ChangePasswordUseCase
    {
        $userPostgresRepository       = new UserPostgresRepository(Postgres::connect());
        $passwordHashImplementation   = new PasswordHashImplementation();
        $authenticatedUserInformation = new AuthenticatedUserInformation($userPostgresRepository);
        $dateAndTimeImplementation    = new DateAndTimeImplementation();
        
        return new ChangePasswordUseCase(
            $authenticatedUserInformation,
            $userPostgresRepository,
            $passwordHashImplementation,
            $dateAndTimeImplementation
        );
    }
}