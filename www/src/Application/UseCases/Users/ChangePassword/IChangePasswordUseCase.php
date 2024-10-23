<?php

namespace App\Application\UseCases\Users\ChangePassword;

use App\Application\DTOs\Users\ChangePasswordDTO;

interface IChangePasswordUseCase
{
    public function execute(ChangePasswordDTO $changePasswordDTO): void;
}