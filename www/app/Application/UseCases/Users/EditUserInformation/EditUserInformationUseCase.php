<?php

namespace App\Application\UseCases\Users\EditUserInformation;

use App\Application\DTOs\Users\EditUserInformationDTO;
use App\Domain\Entities\User;
use App\Domain\Ports\Out\UserRepositoryPort;
use App\Domain\Services\DateAndTime;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;

class EditUserInformationUseCase implements IEditUserInformationUseCase
{
    public function __construct(
        private readonly UserRepositoryPort $userRepositoryPort,
        private readonly DateAndTime $dateAndTime
    ) {
    }
    
    public function execute(EditUserInformationDTO $editUserInformationDTO): User
    {
        $currentDateTime = $this->dateAndTime->currentDateTime();

        $update = $this->userRepositoryPort->updateUsername(
            $editUserInformationDTO->getName(),
            $currentDateTime,
            $editUserInformationDTO->getId()
        );
        
        if (!$update) {
            throw new BadRequestException("Sorry, we couldn't update user information.");
        }
        
        return $update;
    }
}