<?php

use App\Actions\Auth\LogoutAction;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'user', 'logout');

beforeEach(function () {
    $this->action = new LogoutAction();
});

test('logout action success', function () {
    JWTAuth::expects('invalidate')
        ->with(true)
        ->andReturnNull();

    $response = $this->action->execute();

    expect($response)->toBeNull();
});
