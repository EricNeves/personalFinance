<?php

namespace App\Application\UseCases\Users\ChangePassword;

use App\Application\DTOs\Users\ChangePasswordDTO;
use App\Application\Shared\AuthenticatedUserInformation;
use App\Domain\Ports\Out\UserRepositoryPort;
use App\Domain\Services\DateAndTime;
use App\Domain\Services\PasswordHash;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;
use App\Infrasctructure\Exceptions\ApplicationErrors\UnauthorizedException;

class ChangePasswordUseCase implements IChangePasswordUseCase
{
    public function __construct(
        private readonly AuthenticatedUserInformation $authenticatedUserInformation,
        private readonly UserRepositoryPort $userRepositoryPort,
        private readonly PasswordHash $passwordHash,
        private readonly DateAndTime $dateAndTime
    ) {
    }
    
    public function execute(ChangePasswordDTO $changePasswordDTO): void
    {
        $user = $this->authenticatedUserInformation->fetch($changePasswordDTO->getId());
        
        if (!$this->passwordHash->verify($changePasswordDTO->getOldPassword(), $user->getPassword())) {
            throw new UnauthorizedException('Old password does not match.');
        }

        $currentDateTime = $this->dateAndTime->currentDateTime();
        
        $hashNewPassword = $this->passwordHash->hash($changePasswordDTO->getNewPassword());
        
        $updatePassword = $this->userRepositoryPort->updatePassword($hashNewPassword, $currentDateTime, $user->getId());
        
        if (!$updatePassword) {
            throw new BadRequestException('Failed to update password.');
        }
    }
}