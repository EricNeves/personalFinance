<?php

namespace App\Application\UseCases\Users\EditUserInformation;

use App\Application\DTOs\Users\EditUserInformationDTO;
use App\Domain\Entities\User;

interface IEditUserInformationUseCase
{
    public function execute(EditUserInformationDTO $editUserInformationDTO): User;
}