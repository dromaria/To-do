<?php

use App\Actions\Auth\MeAction;
use App\Actions\Auth\VerifyEmailAction;
use App\Models\User;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'email', 'verify');

beforeEach(function () {
    $this->repository = Mockery::mock(EmailRepositoryInterface::class);
    $this->action = new VerifyEmailAction($this->repository);
});

test('verify email action success', function () {

    $user = User::factory()
        ->withID(1)
        ->make(['email_verified_at' => null]);

    $code = fake()->numerify('######');

    $meActionMock = Mockery::mock(MeAction::class);

    $meActionMock->expects('execute')->andReturn($user);

    $this->repository->expects('getCode')->with($user)->andReturn($code);

    $this->repository->expects('verifyCode')->with($user, $code, $code)->andReturnNull();

    $response = $this->action->execute($code, $meActionMock);

    expect($response)->toBeNull();
});
