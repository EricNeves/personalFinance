<?php

namespace App\Domain\Ports\Out;

use App\Domain\Entities\User;

interface UserRepositoryPort
{
    public function save(User $user): bool;
}