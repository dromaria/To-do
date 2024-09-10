<?php

use App\Actions\Auth\MeAction;
use App\Actions\Auth\SendEmailAction;
use App\Jobs\SendEmailCode;
use App\Models\User;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'email', 'send');

beforeEach(function () {
    $this->repository = Mockery::mock(EmailRepositoryInterface::class);
    $this->action = new SendEmailAction($this->repository);
});

test('send email action success', function () {

    $user = User::factory()
        ->withID(1)
        ->make(['email_verified_at' => null]);

    $meActionMock = Mockery::mock(MeAction::class);
    $meActionMock->expects('execute')->andReturn($user);

    $code = fake()->numerify('######');

    $this->repository->expects('storeCode')->andReturn($code);

    Mockery::mock('overload:'.SendEmailCode::class)
        ->expects('dispatchIf')
        ->with(true, $user, $code)
        ->andReturnNull();

    $response = $this->action->execute($meActionMock);

    expect($response)->toBeNull();
});
