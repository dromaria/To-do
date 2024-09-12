<?php

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

    $this->action->expects('execute')
        ->andReturnNull();

    post(
        '/api/auth/email_send',
        headers: ['Authorization' => 'Bearer ' . $token]
    )
       ->assertNoContent();
});
