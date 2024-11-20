<?php

use App\Application\Services\User\UserEmailAlreadyExists;
use App\Infrasctructure\Exceptions\ApplicationErrors\EmailAlreadyExistsException;

it('throws an exception when email already exists', function () {
    $userRepository = mockUserRepository();

    $userRepository->shouldReceive('emailExists')->andReturn(true);

    $userEmailAlreadyExists = new UserEmailAlreadyExists($userRepository);

    $userEmailAlreadyExists->verify('johndoe@example.com');
})->throws(EmailAlreadyExistsException::class);