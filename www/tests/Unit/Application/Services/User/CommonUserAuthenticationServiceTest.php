<?php

use App\Domain\Entities\User;
use App\Application\Services\User\CommonUserAuthenticationService;
use App\Infrasctructure\Exceptions\ApplicationErrors\UnauthorizedException;

it('authenticate and return token jwt', function () {
    $userRepository = mockUserRepository();
    $passwordHash   = mockPasswordHash();
    $tokenService   = mockTokenService();

    $user = new User('1', 'John Doe', 'johndoe@example.com', '123456');

    $userRepository->shouldReceive('findByEmail')->andReturn($user);
    $passwordHash->shouldReceive('verify')->andReturn(true);
    $tokenService->shouldReceive('sign')->andReturn('jwt token');

    $commonUserAuthenticationService = new CommonUserAuthenticationService(
        $userRepository,
        $passwordHash,
        $tokenService
    );

    $token = $commonUserAuthenticationService->authenticate('johndoe@example.com', '123456');

    expect($token)->toBe('jwt token');
});

it('throws an exception when user does not exists', function () {
    $userRepository = mockUserRepository();
    $passwordHash   = mockPasswordHash();
    $tokenService   = mockTokenService();

    $userRepository->shouldReceive('findByEmail')->andReturn(null);
    $passwordHash->shouldReceive('verify')->andReturn(true);
    $tokenService->shouldReceive('sign')->andReturn('jwt token');

    $commonUserAuthenticationService = new CommonUserAuthenticationService(
        $userRepository,
        $passwordHash,
        $tokenService
    );

    $commonUserAuthenticationService->authenticate('johndoe@example.com', '123456');
})->throws(UnauthorizedException::class);

it('throws an exception when password not match', function () {
    $userRepository = mockUserRepository();
    $passwordHash   = mockPasswordHash();
    $tokenService   = mockTokenService();

    $user = new User('1', 'John Doe', 'johndoe@example.com', '123456');

    $userRepository->shouldReceive('findByEmail')->andReturn($user);
    $passwordHash->shouldReceive('verify')->andReturn(false);
    $tokenService->shouldReceive('sign')->andReturn('jwt token');

    $commonUserAuthenticationService = new CommonUserAuthenticationService(
        $userRepository,
        $passwordHash,
        $tokenService
    );

    $commonUserAuthenticationService->authenticate('johndoe@example.com', '123456');
})->throws(UnauthorizedException::class);