<?php

namespace App\Application\Shared;

use App\Domain\Ports\Out\UserRepositoryPort;
use App\Infrasctructure\Exceptions\ApplicationErrors\EmailAlreadyExistsException;

class UserEmailAlreadyExists
{
    public function __construct(private readonly UserRepositoryPort $userRepositoryPort)
    {
    }
    
    public function verify(string $email): void
    {
        $emailExists = $this->userRepositoryPort->emailExists($email);
        
        if ($emailExists) {
            throw new EmailAlreadyExistsException("Sorry, email already exists.");
        }
    }
}