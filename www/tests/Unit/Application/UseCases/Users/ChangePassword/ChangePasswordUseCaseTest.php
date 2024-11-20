<?php

use App\Application\DTOs\Users\ChangePasswordDTO;
use App\Application\UseCases\Users\ChangePassword\ChangePasswordUseCase;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;
use App\Domain\Entities\User;

it('can change password', function () {
    $authenticateUserInfo = mockAuthenticatedUserInformation();
    $userRepository       = mockUserRepository();
    $passwordHash         = mockPasswordHash();
    $dateAndTime          = mockDateAndTimeService();

    $user = new User('1', 'John', 'john@example.com', '1235');
    $changePasswordDTO = new ChangePasswordDTO('1235', '1234', '1');

    $authenticateUserInfo->shouldReceive('fetch')->andReturn($user);
    $passwordHash->shouldReceive('verify')->andReturn(true);
    $dateAndTime->shouldReceive('currentDateTime')->andReturn('2024-11-14 00:33:26');
    $passwordHash->shouldReceive('hash')->andReturn('hashed');
    $userRepository->shouldReceive('updatePassword')->andReturn(true);

    $changePasswordUseCase = new ChangePasswordUseCase(
        $authenticateUserInfo,
        $userRepository,
        $passwordHash,
        $dateAndTime
    );

    $changePasswordUseCase->execute($changePasswordDTO);

    expect($user)->toBeInstanceOf(User::class);
});

it('throws an exception if password does not match', function () {
    $authenticateUserInfo = mockAuthenticatedUserInformation();
    $userRepository       = mockUserRepository();
    $passwordHash         = mockPasswordHash();
    $dateAndTime          = mockDateAndTimeService();

    $user = new User('1', 'John', 'john@example.com', '1235');
    $changePasswordDTO = new ChangePasswordDTO('1235', '1234', '1');

    $authenticateUserInfo->shouldReceive('fetch')->andReturn($user);
    $passwordHash->shouldReceive('verify')->andReturn(false);
    $dateAndTime->shouldReceive('currentDateTime')->andReturn('2024-11-14 00:33:26');
    $passwordHash->shouldReceive('hash')->andReturn('hashed');
    $userRepository->shouldReceive('updatePassword')->andReturn(true);

    $changePasswordUseCase = new ChangePasswordUseCase(
        $authenticateUserInfo,
        $userRepository,
        $passwordHash,
        $dateAndTime
    );

    $changePasswordUseCase->execute($changePasswordDTO);

    expect($user)->toBeInstanceOf(User::class);
})->throws(BadRequestException::class);

it('throws an exception if the password could not be updated', function () {
    $authenticateUserInfo = mockAuthenticatedUserInformation();
    $userRepository       = mockUserRepository();
    $passwordHash         = mockPasswordHash();
    $dateAndTime          = mockDateAndTimeService();

    $user = new User('1', 'John', 'john@example.com', '1235');
    $changePasswordDTO = new ChangePasswordDTO('1235', '1234', '1');

    $authenticateUserInfo->shouldReceive('fetch')->andReturn($user);
    $passwordHash->shouldReceive('verify')->andReturn(true);
    $dateAndTime->shouldReceive('currentDateTime')->andReturn('2024-11-14 00:33:26');
    $passwordHash->shouldReceive('hash')->andReturn('hashed');
    $userRepository->shouldReceive('updatePassword')->andReturn(false);

    $changePasswordUseCase = new ChangePasswordUseCase(
        $authenticateUserInfo,
        $userRepository,
        $passwordHash,
        $dateAndTime
    );

    $changePasswordUseCase->execute($changePasswordDTO);

    expect($user)->toBeInstanceOf(User::class);
})->throws(BadRequestException::class);