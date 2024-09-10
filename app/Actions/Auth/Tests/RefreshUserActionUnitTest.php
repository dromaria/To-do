<?php

use App\Actions\Auth\RefreshAction;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'user', 'me');

beforeEach(function () {
    $this->repository = Mockery::mock(UserRepositoryInterface::class);
    $this->action = new RefreshAction($this->repository);
});

test('refresh action success', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $this->repository->expects('refresh')->andReturn($token);

    $response = $this->action->execute();

    expect($response)->toEqual($token);
});
