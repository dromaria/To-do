<?php

use App\Actions\Auth\MeAction;
use App\Actions\Auth\VerifyEmailAction;
use App\Models\User;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'email', 'verify');

beforeEach(function () {
    $this->emailRepository = Mockery::mock(EmailRepositoryInterface::class);
    $this->userRepository = Mockery::mock(UserRepositoryInterface::class);
    $this->meAction = Mockery::mock(MeAction::class);
    $this->action = new VerifyEmailAction($this->emailRepository, $this->userRepository, $this->meAction);
});

test('verify email action success', function () {

    $user = User::factory()
        ->withID(1)
        ->make(['email_verified_at' => null]);

    $code = fake()->numerify('######');

    $this->meAction->expects('execute')->andReturn($user);

    $this->emailRepository->expects('getCode')->with($user->id)->andReturn($code);

    $this->userRepository->expects('verifyEmail')->with($user)->andReturnNull();

    $response = $this->action->execute($code, $user);

    expect($response)->toBeNull();
});
