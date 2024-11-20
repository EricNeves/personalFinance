<?php

use App\Application\DTOs\Users\RegisterUserDTO;
use App\Domain\Entities\User;
use App\Application\UseCases\Users\RegisterUser\RegisterUserUseCase;
use App\Infrasctructure\Exceptions\ApplicationErrors\RegisterUserException;

it('register a new user', function () {
    $userRepository          = mockUserRepository();
    $userEmailAlreadyExists  = mockUserEmailAlreadyExists();
    $saveInitialValueBalance = mockSaveInitialValueBalance();
    $uuidGenerator           = mockUuidGenerator();
    $passwordHash            = mockPasswordHash();
    $dateAndTime             = mockDateAndTimeService();

    $registerUserDTO = new RegisterUserDTO('John Doe', 'john@doe.com', '123');

    $passwordHash->shouldReceive('hash')->andReturn('hashed');
    $uuidGenerator->shouldReceive('generateV4')->andReturn('8d8c96d9-a6cd-4231-902c-3f56a9849205');
    $dateAndTime->shouldReceive('currentDateTime')->andReturn('2024-11-14 00:33:26');
    $userEmailAlreadyExists->shouldReceive('verify')->andReturn();
    $userRepository->shouldReceive('save')->andReturn(true);
    $saveInitialValueBalance->shouldReceive('register')->andReturn();

    $registerUserUseCase = new RegisterUserUseCase(
        $userRepository,
        $userEmailAlreadyExists,
        $saveInitialValueBalance,
        $uuidGenerator,
        $passwordHash,
        $dateAndTime,
    );

    expect($registerUserUseCase->execute($registerUserDTO))->toBeInstanceOf(User::class);
});

it('throws an exception if the user could not be saved', function () {
    $userRepository          = mockUserRepository();
    $userEmailAlreadyExists  = mockUserEmailAlreadyExists();
    $saveInitialValueBalance = mockSaveInitialValueBalance();
    $uuidGenerator           = mockUuidGenerator();
    $passwordHash            = mockPasswordHash();
    $dateAndTime             = mockDateAndTimeService();

    $registerUserDTO = new RegisterUserDTO('John Doe', 'john@doe.com', '123');

    $passwordHash->shouldReceive('hash')->andReturn('hashed');
    $uuidGenerator->shouldReceive('generateV4')->andReturn('8d8c96d9-a6cd-4231-902c-3f56a9849205');
    $dateAndTime->shouldReceive('currentDateTime')->andReturn('2024-11-14 00:33:26');
    $userEmailAlreadyExists->shouldReceive('verify')->andReturn();
    $userRepository->shouldReceive('save')->andReturn(false);
    $saveInitialValueBalance->shouldReceive('register')->andReturn();

    $registerUserUseCase = new RegisterUserUseCase(
        $userRepository,
        $userEmailAlreadyExists,
        $saveInitialValueBalance,
        $uuidGenerator,
        $passwordHash,
        $dateAndTime,
    );

    $registerUserUseCase->execute($registerUserDTO);
})->throws(RegisterUserException::class);