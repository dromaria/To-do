<?php

use App\Actions\Auth\MeAction;
use App\Actions\Auth\VerifyEmailAction;
use App\Models\User;
use Tests\UnitTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use function Pest\Laravel\post;

uses(UnitTestCase::class)
    ->group('unit', 'controller', 'email', 'verify');

beforeEach(function () {
    $this->action = Mockery::mock(VerifyEmailAction::class);
    $this->app->instance(VerifyEmailAction::class, $this->action);
});

test('POST /auth/email_verify: 204', function () {

    $user = User::factory()
        ->withID(1)
        ->make(['email_verified_at' => null]);

    $code = fake()->numerify('######');

    $token = JWTAuth::fromUser($user);

    $meActionMock = Mockery::mock(MeAction::class);
    $this->app->instance(MeAction::class, $meActionMock);

    $this->action->expects('execute')
        ->with($code, $meActionMock)
        ->andReturnNull();

    post(
        '/api/auth/email_verify',
        ['code' => $code],
        ['Authorization' => 'Bearer ' . $token]
    )
       ->assertNoContent();
});

test('POST /auth/email_verify: 422', function (string $request) {

    $user = User::factory()
        ->withID(1)
        ->make(['email_verified_at' => null]);

    $code = fake()->numerify('######');

    $token = JWTAuth::fromUser($user);

    $meActionMock = Mockery::mock(MeAction::class);
    $this->app->instance(MeAction::class, $meActionMock);

    $this->action->expects('execute')
        ->with($code, $meActionMock)
        ->never();

    post('/api/auth/email_verify', (array)$request, ['Authorization' => 'Bearer ' . $token])
        ->assertStatus(422);
})->with([
    'empty data' => ['code' => ''],
    'mismatched code' => ['code' => fake()->numerify('######')],
    'invalid code' => ['code' => fake()->numerify('#')],
]);
