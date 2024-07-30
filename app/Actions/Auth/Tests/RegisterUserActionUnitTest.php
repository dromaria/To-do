<?php

use App\Actions\Auth\RegisterAction;
use App\DTO\User\RegisterUserDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'user', 'register');

beforeEach(function () {
    $this->repository = Mockery::mock(UserRepositoryInterface::class);
    $this->action = new RegisterAction($this->repository);
});

test('register success', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $dto = new RegisterUserDTO();

    $this->repository->expects('register')
        ->andReturnNull();

    $response = $this->action->execute($dto);
    expect($response)->toBeNull();
});
