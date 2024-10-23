<?php

namespace App\Application\UseCases\Users\FetchUser;

use App\Domain\Entities\User;

interface IFetchUserUseCase
{
    public function execute(string $id): User;
}