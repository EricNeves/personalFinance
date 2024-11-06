<?php

namespace App\Adapters\Out\Factories\Users;

use App\Adapters\Out\Persistence\Repositories\UserPostgresRepository;
use App\Application\Services\AuthenticatedUserInformation;
use App\Application\UseCases\Users\FetchUser\FetchUserUseCase;
use App\Infrasctructure\Database\Postgres;

class FetchUserFactory
{
    public function init(): FetchUserUseCase
    {
        $userPostgresRepository       = new UserPostgresRepository(Postgres::connect());
        $authenticatedUserInformation = new AuthenticatedUserInformation($userPostgresRepository);

        return new FetchUserUseCase($authenticatedUserInformation);
    }
}