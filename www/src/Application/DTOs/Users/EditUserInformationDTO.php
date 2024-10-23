<?php

namespace App\Application\DTOs\Users;

class EditUserInformationDTO
{
    public function __construct(
        private readonly string $id,
        private readonly string $name
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
}