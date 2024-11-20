<?php

namespace App\Application\UseCases\Users\RegisterUser;

use App\Application\DTOs\Users\RegisterUserDTO;
use App\Application\Services\Transaction\SaveInitialValueBalance;
use App\Application\Services\User\UserEmailAlreadyExists;
use App\Domain\Entities\Balance;
use App\Domain\Entities\User;
use App\Domain\Ports\Out\UserRepositoryPort;
use App\Domain\Services\DateAndTime;
use App\Domain\Services\PasswordHash;
use App\Domain\Services\Uuid;
use App\Infrasctructure\Exceptions\ApplicationErrors\RegisterUserException;

class RegisterUserUseCase implements IRegisterUserUseCase
{
    public function __construct(
        private readonly UserRepositoryPort $userRepositoryPort,
        private readonly UserEmailAlreadyExists $userEmailAlreadyExists,
        private readonly SaveInitialValueBalance $saveInitialValueBalance,
        private readonly Uuid $uuid,
        private readonly PasswordHash $passwordHash,
        private readonly DateAndTime $dataAndTime
    ) {
    }
    
    public function execute(RegisterUserDTO $registerUserDTO): User
    {
        $password     = $this->passwordHash->hash($registerUserDTO->getPassword());
        $userUuid     = $this->uuid->generateV4();
        $balanceUuid  = $this->uuid->generateV4();
        $dateTime     = $this->dataAndTime->currentDateTime();
        
        $this->userEmailAlreadyExists->verify($registerUserDTO->getEmail());
        
        $user = new User($userUuid, $registerUserDTO->getName(), $registerUserDTO->getEmail(), $password, $dateTime);
        
        $save = $this->userRepositoryPort->save($user);
        
        if (!$save) {
            throw new RegisterUserException('Sorry, we could not register your account, try again later.');
        }
        
        $balance = new Balance($balanceUuid, 0, 0, 0, $user->getId());

        $this->saveInitialValueBalance->register($balance);
        
        return $user;
    }
}