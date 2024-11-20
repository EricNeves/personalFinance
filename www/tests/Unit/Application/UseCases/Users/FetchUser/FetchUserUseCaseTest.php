<?php

use App\Domain\Entities\User;
use App\Application\UseCases\Users\FetchUser\FetchUserUseCase;

it('can show user information', function () {
    $authenticateUserInformation = mockAuthenticatedUserInformation();

    $user = new User('1', 'John', 'john@example.com');

    $authenticateUserInformation->shouldReceive('fetch')->andReturn($user);

    $fetchUserUseCase = new FetchUserUseCase($authenticateUserInformation);

    expect($fetchUserUseCase->execute('1'))->toBeInstanceOf(User::class);
});