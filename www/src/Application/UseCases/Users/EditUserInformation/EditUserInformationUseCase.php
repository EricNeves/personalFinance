<?php

namespace App\Application\UseCases\Users\EditUserInformation;

use App\Application\DTOs\Users\EditUserInformationDTO;
use App\Domain\Entities\User;
use App\Domain\Ports\Out\UserRepositoryPort;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;

class EditUserInformationUseCase implements IEditUserInformationUseCase
{
    public function __construct(private readonly UserRepositoryPort $userRepositoryPort)
    {
    }
    
    public function execute(EditUserInformationDTO $editUserInformationDTO): User
    {
        $update = $this->userRepositoryPort->updateUsername(
            $editUserInformationDTO->getName(),
            $editUserInformationDTO->getId()
        );
        
        if (!$update) {
            throw new BadRequestException("Sorry, we couldn't update user information.");
        }
        
        return $update;
    }
}