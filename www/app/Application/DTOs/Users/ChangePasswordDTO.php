<?php

namespace App\Application\DTOs\Users;

class ChangePasswordDTO
{
    public function __construct(
        private readonly string $oldPassword,
        private readonly string $newPassword,
        private readonly string $id
    ) {
    }
    
    public function getOldPassword(): string
    {
        return $this->oldPassword;
    }
    
    public function getNewPassword(): string
    {
        return $this->newPassword;
    }
    
    public function getId(): string
    {
        return $this->id;
    }
}