<?php

use App\Actions\Auth\LoginAction;
use App\DTO\User\UserDTO;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tests\UnitTestCase;
use function Pest\Laravel\post;

uses(UnitTestCase::class)
    ->group('unit', 'controller', 'user', 'login');


beforeEach(function () {

    $this->action = Mockery::mock(LoginAction::class);
    $this->app->instance(LoginAction::class, $this->action);
});

test('POST /auth/login: 200', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $modelDTO = new UserDTO([
        'email' => $user->email,
        'password' => $user->password
    ]);

    $this->action->expects('execute')
        ->with(Mockery::mustBe($modelDTO))
        ->andReturn([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
            ]);

    post(
        '/api/auth/login',
        [
            'email' => $user->email,
            'password' => $user->password,
        ]
    )->assertOk()
        ->assertJson([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
});

test('POST /auth/login: 401', function () {

    $user = User::factory()
        ->withID(1)
        ->make();


    $modelDTO = new UserDTO([
        'email' => $user->email,
        'password' => $user->password
    ]);

    $this->action->expects('execute')
        ->with(Mockery::mustBe($modelDTO))
        ->andThrow(UnauthorizedHttpException::class);

    post(
        '/api/auth/login',
        [
            'email' => $user->email,
            'password' => $user->password
        ]
    )->assertStatus(401);
});

test('POST /auth/login: 422', function (array $request) {

    $this->action->expects('execute')
        ->never();

    post('/api/auth/login', $request)
        ->assertStatus(422);
})->with([
    'empty data' => [
        ['email' => '', 'password' => '']
    ],
    'empty email' => [
        ['email' => '', 'password' => fake()->password(8)]
    ],
    'empty password' => [
        ['email' => fake()->unique()->safeEmail(), 'password' => '']
    ],
])
;
