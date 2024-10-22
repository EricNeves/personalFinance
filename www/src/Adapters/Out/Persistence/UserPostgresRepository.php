<?php

namespace App\Adapters\Out\Persistence;


use App\Domain\Entities\User;
use App\Domain\Ports\Out\UserRepositoryPort;
use PDO;

class UserPostgresRepository implements UserRepositoryPort
{
    public function __construct(private readonly PDO $db)
    {
    }

    public function save(User $user): bool
    {
        $stmt = $this->db->prepare("INSERT INTO users (id, name, email, password) values (?, ?, ?, ?)");
        $stmt->execute([$user->getId(), $user->getName(), $user->getEmail(), $user->getPassword()]);

        if (!$this->db->lastInsertId() > 0) {
            return false;
        }

        return true;
    }
}
