<?php

use App\Actions\Auth\LoginAction;
use App\DTO\User\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'user', 'login');

beforeEach(function () {
    $this->action = new LoginAction();
});

test('login action success', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $dto = new UserDTO();

    $token = JWTAuth::fromUser($user);

    Auth::expects('attempt')
        ->with($dto->toArray())
        ->andReturn($token);

    Auth::shouldReceive('factory')->andReturnSelf();
    Auth::shouldReceive('getTTl')->andReturn(60);

    $response = $this->action->execute($dto);

    expect($response)->toEqual([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => Auth::factory()->getTTL() * 60
    ]);
});
