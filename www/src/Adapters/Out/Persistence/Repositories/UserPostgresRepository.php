<?php

namespace App\Adapters\Out\Persistence\Repositories;


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

        if (!$stmt->rowCount() > 0) {
            return false;
        }

        return true;
    }
    
    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            return true;
        }
        
        return false;
    }
    
    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return new User($row['id'], $row['name'], $row['email'], $row['password']);
        }
        
        return null;
    }

    public function findById(string $id): ?User
    {
        $stmt = $this->db->prepare("SELECT id, name, email FROM users WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return new User($row['id'], $row['name'], $row['email']);
        }

        return null;
    }
    
    public function updateUsername(string $name, string $userID): ?User
    {
        $stmt = $this->db->prepare("UPDATE users SET name = ? WHERE id = ?");
        $stmt->execute([$name, $userID]);
        
        if ($stmt->rowCount() > 0) {
            return $this->findById($userID);
        }
        
        return null;
    }
}
