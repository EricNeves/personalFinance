<?php

use App\Application\Services\AuthenticatedUserInformation;
use App\Adapters\Out\Persistence\Repositories\UserPostgresRepository;
use App\Domain\Entities\User;
use App\Infrasctructure\Exceptions\ApplicationErrors\NotFoundException;

it('gets user information', function () {
    $userRepository = Mockery::mock(UserPostgresRepository::class);
    
    $user = new User('1', 'John', 'john@example.com');
    
    $userRepository->shouldReceive('findById')->andReturn($user);
    
    $authenticatedUserInformation = new AuthenticatedUserInformation($userRepository);
    
    expect($authenticatedUserInformation->fetch('1'))->toBeInstanceOf(User::class);
});

it('throws an exception when the user does not exists', function () {
    $userRepository = Mockery::mock(UserPostgresRepository::class);
    
    $user = new User('1', 'John', 'john@example.com');
    
    $userRepository->shouldReceive('findById')->andReturn(null);
    
    $authenticatedUserInformation = new AuthenticatedUserInformation($userRepository);
    
    $authenticatedUserInformation->fetch('1');
})->throws(NotFoundException::class);