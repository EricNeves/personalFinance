<?php

namespace App\Adapters\Out\Factories\Users;

use App\Adapters\Out\Persistence\Repositories\UserPostgresRepository;
use App\Adapters\Out\Services\PasswordPasswordHashImplementation;
use App\Adapters\Out\Services\TokenServiceImplementation;
use App\Application\Services\CommonUserAuthenticationService;
use App\Application\UseCases\Users\AuthenticateUser\AuthenticateUserUseCase;
use App\Infrasctructure\Database\Postgres;

class AuthenticateUserFactory
{
    public function init(): AuthenticateUserUseCase
    {
        $userPostgresRepository          = new UserPostgresRepository(Postgres::connect());
        $passwordHashImplementation      = new PasswordPasswordHashImplementation();
        $tokenServiceImplementation      = new TokenServiceImplementation();
        $commonUserAuthenticationService = new CommonUserAuthenticationService(
            $userPostgresRepository,
            $passwordHashImplementation,
            $tokenServiceImplementation
        );
        
        return new AuthenticateUserUseCase($commonUserAuthenticationService);
    }
}