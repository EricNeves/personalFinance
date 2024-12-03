<?php

use App\Adapters\Out\Persistence\Repositories\UserPostgresRepository;
use App\Domain\Entities\User;

beforeEach(function () {
    $this->pdoStatement = mockPDOStatement();
    $this->pdo          = mockPDO();

    $this->repository = new UserPostgresRepository($this->pdo);
});

it('returns true if the user saved with repository', function () {
    $this->pdoStatement->shouldReceive('execute')->andReturn(true);
    $this->pdoStatement->shouldReceive('rowCount')->andReturn(1);

    $this->pdo->shouldReceive('prepare')->andReturn($this->pdoStatement);

    $repository = new UserPostgresRepository($this->pdo);

    $user = new User(
        '1',
        'John Doe',
        'john@doe.com',
        '123',
        '2024-11-27 13:32:00'
    );

    $save = $repository->save($user);

    expect($save)->toBeTrue();
});

it('returns false if the user could not be saved with repository', function() {
    $this->pdoStatement->shouldReceive('execute')->andReturn(false);
    $this->pdoStatement->shouldReceive('rowCount')->andReturn(0);

    $this->pdo->shouldReceive('prepare')->andReturn($this->pdoStatement);

    $repository = new UserPostgresRepository($this->pdo);

    $user = new User(
        '1',
        'John Doe',
        'john@doe.com',
        '123',
        '2024-11-27 13:32:00'
    );

    $save = $repository->save($user);

    expect($save)->toBeFalse();
});

it('returns true if email already exist', function () {
    $this->pdoStatement->shouldReceive('execute')->andReturn(true);
    $this->pdoStatement->shouldReceive('rowCount')->andReturn(1);

    $this->pdo->shouldReceive('prepare')->andReturn($this->pdoStatement);

    $repository = new UserPostgresRepository($this->pdo);

    $emailExists = $repository->emailExists('john@doe.com');

    expect($emailExists)->toBeTrue();
});

it('returns false if email does not exist', function () {
    $this->pdoStatement->shouldReceive('execute')->andReturn(false);
    $this->pdoStatement->shouldReceive('rowCount')->andReturn(0);

    $this->pdo->shouldReceive('prepare')->andReturn($this->pdoStatement);

    $repository = new UserPostgresRepository($this->pdo);

    $emailExists = $repository->emailExists('john@doe.com');

    expect($emailExists)->toBeFalse();
});

it('returns entity by email if user exists', function () {
    $this->pdoStatement->shouldReceive('execute')->andReturn(true);
    $this->pdoStatement->shouldReceive('rowCount')->andReturn(1);
    $this->pdoStatement->shouldReceive('fetch')->andReturn([
        'id'         => '1',
        'name'       => 'John Doe',
        'email'      => 'john@doe.com',
        'password'   => '123',
        'created_at' => '2024-11-27 13:32:00',
        'updated_at' => '2024-11-27 13:32:00'
    ]);

    $this->pdo->shouldReceive('prepare')->andReturn($this->pdoStatement);

    $repository = new UserPostgresRepository($this->pdo);

    $user = $repository->findByEmail('john@doe.com');

    expect($user)->toBeInstanceOf(User::class);
});

it('returns null if the user by email does not exist', function () {
    $this->pdoStatement->shouldReceive('execute')->andReturn(false);
    $this->pdoStatement->shouldReceive('rowCount')->andReturn(0);

    $this->pdo->shouldReceive('prepare')->andReturn($this->pdoStatement);

    $repository = new UserPostgresRepository($this->pdo);

    $user = $repository->findByEmail('john@doe.com');

    expect($user)->toBeNull();
});

it('returns entity by id if user exists', function () {
    $this->pdoStatement->shouldReceive('execute')->andReturn(true);
    $this->pdoStatement->shouldReceive('rowCount')->andReturn(1);
    $this->pdoStatement->shouldReceive('fetch')->andReturn([
        'id'         => '1',
        'name'       => 'John Doe',
        'email'      => 'john@doe.com',
        'password'   => '123',
        'created_at' => '2024-11-27 13:32:00',
        'updated_at' => '2024-11-27 13:32:00'
    ]);

    $this->pdo->shouldReceive('prepare')->andReturn($this->pdoStatement);

    $repository = new UserPostgresRepository($this->pdo);

    $user = $repository->findById('john@doe.com');

    expect($user)->toBeInstanceOf(User::class);
});

it('returns null if the user by id does not exist', function () {
    $this->pdoStatement->shouldReceive('execute')->andReturn(false);
    $this->pdoStatement->shouldReceive('rowCount')->andReturn(0);

    $this->pdo->shouldReceive('prepare')->andReturn($this->pdoStatement);

    $repository = new UserPostgresRepository($this->pdo);

    $user = $repository->findById('john@doe.com');

    expect($user)->toBeNull();
});

it('returns true if the password was updated successfully', function () {
    $this->pdoStatement->shouldReceive('execute')->andReturn(true);
    $this->pdoStatement->shouldReceive('rowCount')->andReturn(1);

    $this->pdo->shouldReceive('prepare')->andReturn($this->pdoStatement);

    $repository = new UserPostgresRepository($this->pdo);

    $updatePassword = $repository->updatePassword('123', '2024-11-27 13:32:00', '1');

    expect($updatePassword)->toBeTrue();
});

it('returns false if the password was updated successfully', function () {
    $this->pdoStatement->shouldReceive('execute')->andReturn(false);
    $this->pdoStatement->shouldReceive('rowCount')->andReturn(0);

    $this->pdo->shouldReceive('prepare')->andReturn($this->pdoStatement);

    $repository = new UserPostgresRepository($this->pdo);

    $updatePassword = $repository->updatePassword('123', '2024-11-27 13:32:00', '1');

    expect($updatePassword)->toBeFalse();
});