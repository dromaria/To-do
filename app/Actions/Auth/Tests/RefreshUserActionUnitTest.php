<?php

use App\Actions\Auth\RefreshAction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'user', 'me');

beforeEach(function () {
    $this->action = new RefreshAction();
});

test('me action success', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    Auth::expects('refresh')
        ->with(true)
        ->andReturn($token);

    $response = $this->action->execute();

    expect($response)->toEqual($token);
});
