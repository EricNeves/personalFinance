<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

// pest()->extend(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}

/**
 * Mocks
 */
function mockUserRepository()
{
    return Mockery::mock(\App\Adapters\Out\Persistence\Repositories\UserPostgresRepository::class);
}

function mockTransactionRepository()
{
    return Mockery::mock(\App\Adapters\Out\Persistence\Repositories\TransactionPostgresRepository::class);
}

function mockBalanceRepository()
{
    return Mockery::mock(\App\Adapters\Out\Persistence\Repositories\BalancePostgresRepository::class);
}

function mockDatabaseTransactionRepository()
{
    return Mockery::mock(\App\Adapters\Out\Services\DatabaseTransactionImplementation::class);
}

function mockRegisterTransaction()
{
    return Mockery::mock(\App\Application\Services\Transaction\RegisterTransaction::class);
}

function mockPasswordHash()
{
    return Mockery::mock(\App\Adapters\Out\Services\PasswordHashImplementation::class);
}

function mockUserEmailAlreadyExists()
{
    return Mockery::mock(\App\Application\Services\User\UserEmailAlreadyExists::class);
}

function mockTokenService()
{
    return Mockery::mock(\App\Adapters\Out\Services\TokenServiceImplementation::class);
}

function mockTransactionTypeValidation()
{
    return Mockery::mock(\App\Application\Shared\TransactionTypeValidation::class);
}

function mockCalculateFinalValueTransaction()
{
    return Mockery::mock(\App\Application\Shared\CalculateFinalValueBalance::class);
}

function mockSaveInitialValueBalance()
{
    return Mockery::mock(\App\Application\Services\Transaction\SaveInitialValueBalance::class);
}

function mockUuidGenerator()
{
    return Mockery::mock(\App\Adapters\Out\Services\UuidGeneratorImplementation::class);
}

function mockDateAndTimeService()
{
    return Mockery::mock(\App\Adapters\Out\Services\DateAndTimeImplementation::class);
}

function mockAuthenticatedUserInformation()
{
    return Mockery::mock(App\Application\Services\User\AuthenticatedUserInformation::class);
}

function mockPDOStatement()
{
    return Mockery::mock(\PDOStatement::class);
}

function mockPDO()
{
    return Mockery::mock(\PDO::class);
}