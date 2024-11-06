<?php

namespace App\Application\DTOs\Users;

class AuthenticateUserDTO
{
    public function __construct(private readonly string $email, private readonly string $password)
    {
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