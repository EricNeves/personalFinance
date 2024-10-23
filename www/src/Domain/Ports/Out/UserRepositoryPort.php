<?php

namespace App\Domain\Ports\Out;

use App\Domain\Entities\User;

interface UserRepositoryPort
{
    public function save(User $user): bool;
    public function emailExists(string $email): bool;
    public function findByEmail(string $email): ?User;
    public function findById(string $id): ?User;
    public function updateUsername(string $name, string $userID): ?User;
    public function updatePassword(string $password, string $userID): bool;
}