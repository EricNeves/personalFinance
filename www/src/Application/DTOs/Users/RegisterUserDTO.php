<?php

namespace App\Application\DTOs\Users;

class RegisterUserDTO
{
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $password
    ) {
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function getPassword(): string
    {
        return $this->password;
    }
}