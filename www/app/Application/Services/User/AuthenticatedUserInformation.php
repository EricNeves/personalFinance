<?php

namespace App\Application\Services\User;

use App\Domain\Entities\User;
use App\Domain\Ports\Out\UserRepositoryPort;
use App\Infrasctructure\Exceptions\ApplicationErrors\NotFoundException;

class AuthenticatedUserInformation
{
    public function __construct(private readonly UserRepositoryPort $userRepositoryPort)
    {
    }

    public function fetch(string $id): User
    {
        $userData = $this->userRepositoryPort->findById($id);

        if (!$userData) {
            throw new NotFoundException('Sorry, the user was not found.');
        }

        return $userData;
    }
}