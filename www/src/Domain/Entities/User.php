<?php

namespace App\Domain\Entities;

use JsonSerializable;

readonly class User implements JsonSerializable
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $email,
        private readonly string $password
    ) {
    }
    
    public function getId(): string
    {
        return $this->id;
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
    
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}