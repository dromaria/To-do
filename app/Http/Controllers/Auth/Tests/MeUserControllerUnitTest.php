<?php

use App\Actions\Auth\MeAction;
use App\Models\User;
use Tests\UnitTestCase;
use function Pest\Laravel\post;

uses(UnitTestCase::class)
    ->group('unit', 'controller', 'user', 'me');

beforeEach(function () {
    $this->action = Mockery::mock(MeAction::class);
    $this->app->instance(MeAction::class, $this->action);
});

test('POST /auth/me: 200', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $this->action->expects('execute')
        ->andReturn($user);

    post(
        '/api/auth/me',
        [
            'email' => $user->email,
            'password' => $user->password,
        ],
        ['Authorization' => 'Bearer ' . $token]
    )->assertOk()
        ->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at->toISOString(),
        ]);
});

test('POST /auth/me: 401', function () {

    $this->action->expects('execute')
        ->never();

    post('/api/auth/logout')->assertStatus(401);
});
