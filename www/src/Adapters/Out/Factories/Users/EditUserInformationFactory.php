<?php

namespace App\Adapters\Out\Factories\Users;

use App\Adapters\Out\Persistence\Repositories\UserPostgresRepository;
use App\Application\UseCases\Users\EditUserInformation\EditUserInformationUseCase;
use App\Infrasctructure\Database\Postgres;

class EditUserInformationFactory
{
    public function init(): EditUserInformationUseCase
    {
        $userPostgresRepository = new UserPostgresRepository(Postgres::connect());
        
        return new EditUserInformationUseCase($userPostgresRepository);
    }
}