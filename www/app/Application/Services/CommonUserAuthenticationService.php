<?php

namespace App\Application\Services;

use App\Domain\Ports\In\CommonAuthenticationPort;
use App\Domain\Ports\Out\TokenServicePort;
use App\Domain\Ports\Out\UserRepositoryPort;
use App\Domain\Services\PasswordHash;
use App\Infrasctructure\Exceptions\ApplicationErrors\UnauthorizedException;

class CommonUserAuthenticationService implements CommonAuthenticationPort
{
    public function __construct(
        private readonly UserRepositoryPort $userRepositoryPort,
        private readonly PasswordHash $passwordHash,
        private readonly TokenServicePort $tokenServicePort
    ) {
    }
    
    public function authenticate(string $email, string $password): string
    {
        $user = $this->userRepositoryPort->findByEmail($email);
        
        if (!$user || !$this->passwordHash->verify($password, $user->getPassword())) {
            throw new UnauthorizedException("Sorry, email or password is incorrect.");
        }
        
        $payload = ['id' => $user->getId(), 'email' => $user->getEmail()];
        
        return $this->tokenServicePort->sign($payload);
    }
}