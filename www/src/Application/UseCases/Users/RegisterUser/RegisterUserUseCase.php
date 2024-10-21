<?php

namespace App\Application\UseCases\Users\RegisterUser;

use App\Application\DTOs\Users\RegisterUserDTO;
use App\Domain\Entities\User;
use App\Domain\Ports\Out\UserRepositoryPort;
use App\Application\Shared\PasswordHarsher;
use App\Application\Shared\UuidGenerator;
use App\Infrasctructure\Exceptions\ApplicationErrors\RegisterUserException;

readonly class RegisterUserUseCase implements IRegisterUserUseCase
{
    public function __construct(
        private readonly UserRepositoryPort $userRepositoryPort,
        private readonly UUIDGenerator $uuidGenerator,
        private readonly PasswordHarsher $passwordHarsher
    ) {
    }
    
    public function execute(RegisterUserDTO $registerUserDTO): void
    {
        $password = $this->passwordHarsher->generateHash($registerUserDTO->getPassword());
        $uuid     = $this->uuidGenerator->generateV4();
        
        $user = new User($uuid, $registerUserDTO->getName(), $registerUserDTO->getEmail(), $password);
        
        $save = $this->userRepositoryPort->save($user);
        
        if (!$save) {
            throw new RegisterUserException("Sorry, we could not register your account, try again later.");
        }
    }
}