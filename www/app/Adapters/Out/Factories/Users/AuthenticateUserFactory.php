<?php

namespace App\Adapters\Out\Factories\Users;

use App\Adapters\Out\Persistence\Repositories\UserPostgresRepository;
use App\Adapters\Out\Services\PasswordHashImplementation;
use App\Adapters\Out\Services\TokenServiceImplementation;
use App\Application\Services\User\CommonUserAuthenticationService;
use App\Application\UseCases\Users\AuthenticateUser\AuthenticateUserUseCase;
use App\Infrasctructure\Database\Postgres;

class AuthenticateUserFactory
{
    public function init(): AuthenticateUserUseCase
    {
        $userPostgresRepository          = new UserPostgresRepository(Postgres::connect());
        $passwordHashImplementation      = new PasswordHashImplementation();
        $tokenServiceImplementation      = new TokenServiceImplementation();
        $commonUserAuthenticationService = new CommonUserAuthenticationService(
            $userPostgresRepository,
            $passwordHashImplementation,
            $tokenServiceImplementation
        );
        
        return new AuthenticateUserUseCase($commonUserAuthenticationService);
    }
}