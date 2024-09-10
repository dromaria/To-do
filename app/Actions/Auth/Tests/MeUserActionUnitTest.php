<?php

use App\Actions\Auth\MeAction;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'user', 'me');

beforeEach(function () {
    $this->repository = Mockery::mock(UserRepositoryInterface::class);
    $this->action = new MeAction($this->repository);
});

test('me action success', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $this->repository->expects('me')->andReturn($user);

    $response = $this->action->execute();

    expect($response)->toEqual($user);
});
