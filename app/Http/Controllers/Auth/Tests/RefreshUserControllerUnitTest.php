<?php

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\RefreshAction;
use App\DTO\User\UserDTO;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tests\UnitTestCase;
use function Pest\Laravel\post;

uses(UnitTestCase::class)
    ->group('unit', 'controller', 'user', 'login');


beforeEach(function () {

    $this->action = Mockery::mock(RefreshAction::class);
    $this->app->instance(RefreshAction::class, $this->action);
});

test('POST /auth/refresh: 200', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    JWTAuth::shouldReceive('requireToken')->with($token)->andReturnSelf();
    JWTAuth::shouldReceive('parser')->andReturnSelf();
    JWTAuth::shouldReceive('setRequest')->andReturnSelf();
    JWTAuth::shouldReceive('hasToken')->andReturnSelf();
    JWTAuth::shouldReceive('parseToken')->andReturnSelf();
    JWTAuth::shouldReceive('authenticate')->andReturnSelf();
    JWTAuth::shouldReceive('factory')->andReturnSelf();
    JWTAuth::shouldReceive('getTTl')->andReturn(60);

    $this->action->expects('execute')
        ->andReturn([
            'access_token' => JWTAuth::shouldReceive('refresh')->andReturnSelf(),
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
            ]);

    post(
        '/api/auth/refresh',
        headers: ['Authorization' => 'Bearer ' . $token]
    )->assertOk()
        ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
});
