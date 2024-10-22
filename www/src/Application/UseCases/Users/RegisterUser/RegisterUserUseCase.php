<?php

namespace App\Application\UseCases\Users\RegisterUser;

use App\Application\DTOs\Users\RegisterUserDTO;
use App\Application\Shared\UserEmailAlreadyExists;
use App\Domain\Entities\User;
use App\Domain\Ports\Out\UserRepositoryPort;
use App\Domain\Services\PasswordHash;
use App\Infrasctructure\Exceptions\ApplicationErrors\RegisterUserException;
use App\Domain\Services\Uuid;

class RegisterUserUseCase implements IRegisterUserUseCase
{
    public function __construct(
        private readonly UserRepositoryPort $userRepositoryPort,
        private readonly UserEmailAlreadyExists $userEmailAlreadyExists,
        private readonly Uuid $uuid,
        private readonly PasswordHash $passwordHash
    ) {
    }
    
    public function execute(RegisterUserDTO $registerUserDTO): User
    {
        $password = $this->passwordHash->hash($registerUserDTO->getPassword());
        $uuid     = $this->uuid->generateV4();
        
        $this->userEmailAlreadyExists->verify($registerUserDTO->getEmail());
        
        $user = new User($uuid, $registerUserDTO->getName(), $registerUserDTO->getEmail(), $password);
        
        $save = $this->userRepositoryPort->save($user);
        
        if (!$save) {
            throw new RegisterUserException('Sorry, we could not register your account, try again later.');
        }
        
        return $user;
    }
}