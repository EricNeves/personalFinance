<?php

use App\Application\DTOs\Users\EditUserInformationDTO;
use App\Application\UseCases\Users\EditUserInformation\EditUserInformationUseCase;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;
use App\Domain\Entities\User;

it('can edit user information', function () {
    $userRepository = mockUserRepository();
    $dateAndTime    = mockDateAndTimeService();

    $editUserInformationDTO = new EditUserInformationDTO('1', 'John J.');

    $user = new User('1', 'John', 'john@example.com', '1235');

    $userRepository->shouldReceive('updateUsername')->andReturn($user);
    $dateAndTime->shouldReceive('currentDateTime')->andReturn('2024-11-14 00:33:26');

    $editUserInformationUseCase = new EditUserInformationUseCase($userRepository, $dateAndTime);

    expect($editUserInformationUseCase->execute($editUserInformationDTO))->toBeInstanceOf(User::class);
});

it('throws an exception if the user could not be updated', function () {
    $userRepository = mockUserRepository();
    $dateAndTime    = mockDateAndTimeService();

    $editUserInformationDTO = new EditUserInformationDTO('1', 'John J.');

    $userRepository->shouldReceive('updateUsername')->andReturn(null);
    $dateAndTime->shouldReceive('currentDateTime')->andReturn('2024-11-14 00:33:26');

    $editUserInformationUseCase = new EditUserInformationUseCase($userRepository, $dateAndTime);

    $editUserInformationUseCase->execute($editUserInformationDTO);
})->throws(BadRequestException::class);