<?php

use App\Actions\Auth\MeAction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'user', 'me');

beforeEach(function () {
    $this->action = new MeAction();
});

test('me action success', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    Auth::expects('user')->andReturn($user);

    $response = $this->action->execute();

    expect($response)->toEqual($user);
});
