<?php

use App\Actions\Auth\LoginAction;
use App\DTO\User\UserDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'user', 'login');

beforeEach(function () {
    $this->repository = Mockery::mock(UserRepositoryInterface::class);
    $this->action = new LoginAction($this->repository);
});

test('login action success', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $dto = new UserDTO($user);

    $token = JWTAuth::fromUser($user);

    $this->repository->expects('attempt')->with($dto)->andReturn($token);

    $response = $this->action->execute($dto);

    expect($response)->toEqual($token);
});
