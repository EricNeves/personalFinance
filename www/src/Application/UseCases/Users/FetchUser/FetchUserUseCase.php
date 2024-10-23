<?php

namespace App\Application\UseCases\Users\FetchUser;

use App\Application\Shared\AuthenticatedUserInformation;
use App\Domain\Entities\User;

class FetchUserUseCase implements IFetchUserUseCase
{
    public function __construct(private readonly AuthenticatedUserInformation $authenticatedUserInformation)
    {
    }

    public function execute(string $id): User
    {
        return $this->authenticatedUserInformation->fetch($id);
    }
}