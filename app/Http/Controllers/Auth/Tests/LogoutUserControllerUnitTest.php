<?php

use App\Actions\Auth\LogoutAction;
use App\Models\User;
use Tests\UnitTestCase;
use function Pest\Laravel\post;

uses(UnitTestCase::class)
    ->group('unit', 'controller', 'user', 'logout');

beforeEach(function () {
    $this->action = Mockery::mock(LogoutAction::class);
    $this->app->instance(LogoutAction::class, $this->action);
});

test('POST /auth/logout: 200', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $this->action->expects('execute')
        ->andReturnNull();

    post('/api/auth/logout', headers: ['Authorization' => 'Bearer ' . $token])
        ->assertNoContent();
});

test('POST /auth/logout: 401', function () {

    $this->action->expects('execute')
        ->never();

    post('/api/auth/logout')->assertStatus(401);
});
