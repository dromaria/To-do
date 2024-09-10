<?php

use App\Actions\Auth\MeAction;
use App\Actions\Auth\SendEmailAction;
use App\Models\User;
use Tests\UnitTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use function Pest\Laravel\post;

uses(UnitTestCase::class)
    ->group('unit', 'controller', 'email', 'send');

beforeEach(function () {
    $this->action = Mockery::mock(SendEmailAction::class);
    $this->app->instance(SendEmailAction::class, $this->action);
});

test('POST /auth/email_send: 204', function () {

    $user = User::factory()
        ->withID(1)
        ->make(['email_verified_at' => null]);

    $token = JWTAuth::fromUser($user);

    $meActionMock = Mockery::mock(MeAction::class);
    $this->app->instance(MeAction::class, $meActionMock);

    $this->action->expects('execute')
        ->with($meActionMock)
        ->andReturnNull();

    post(
        '/api/auth/email_send',
        headers: ['Authorization' => 'Bearer ' . $token]
    )
       ->assertNoContent();
});
