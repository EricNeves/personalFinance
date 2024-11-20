<?php

use App\Application\DTOs\Users\AuthenticateUserDTO;
use App\Application\Services\User\CommonUserAuthenticationService;
use App\Application\UseCases\Users\AuthenticateUser\AuthenticateUserUseCase;
use App\Infrasctructure\Exceptions\ApplicationErrors\UnauthorizedException;

it('authenticate user', function () {
    $commonUserAuthenticationService = Mockery::mock(CommonUserAuthenticationService::class);

    $commonUserAuthenticationService->shouldReceive('authenticate')->andReturn('token');

    $authenticateUserDTO = new AuthenticateUserDTO('john@doe.com', '123456');

    $authenticateUserUseCase = new AuthenticateUserUseCase($commonUserAuthenticationService);

    expect($authenticateUserUseCase->execute($authenticateUserDTO))->toBe('token');
});

it('throws an exception if the user is not authorized', function () {
    $commonUserAuthenticationService = Mockery::mock(CommonUserAuthenticationService::class);

    $commonUserAuthenticationService
        ->shouldReceive('authenticate')
        ->andThrow(UnauthorizedException::class);

    $authenticateUserDTO = new AuthenticateUserDTO('john@doe.com', '123456');

    $authenticateUserUseCase = new AuthenticateUserUseCase($commonUserAuthenticationService);

    $authenticateUserUseCase->execute($authenticateUserDTO);
})->throws(UnauthorizedException::class);