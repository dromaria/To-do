<?php

use App\Actions\Auth\RegisterAction;
use App\DTO\User\RegisterUserDTO;
use App\Models\User;
use Tests\UnitTestCase;
use function Pest\Laravel\post;

uses(UnitTestCase::class)
    ->group('unit', 'controller', 'user', 'register');


beforeEach(function () {

    $this->action = Mockery::mock(RegisterAction::class);
    $this->app->instance(RegisterAction::class, $this->action);
});

test('POST /auth/register: 200', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $modelDTO = new RegisterUserDTO([
        'name' => $user->name,
        'email' => $user->email,
        'password' => $user->password
    ]);

    $this->action->expects('execute')
        ->with(Mockery::mustBe($modelDTO))
        ->andReturn($user);

    post(
        '/api/auth/register',
        [
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password,
            'name' => $user->name
        ]
    )->assertNoContent();
});

test('POST /auth/register: 422', function (array $request) {

    $this->action->expects('execute')
        ->never();

    post('/api/auth/register', $request)
        ->assertStatus(422);
})->with([
    'empty data' =>
        [
            ['email' => '', 'password' => '', 'password_confirmation' => '', 'name' => '']
        ],
    'empty email' =>
        [[
            'email' => '',
            'password' => 'password1!',
            'password_confirmation' => 'password1!',
            'name' => fake()->name()
        ]],
    'empty password' =>
        [[
            'email' => fake()->unique()->safeEmail(),
            'password' => '',
            'password_confirmation' => fake()->password(8),
            'name' => fake()->name()
        ]],
    'empty password_confirmation' =>
        [[
            'email' => fake()->unique()->safeEmail(),
            'password' => fake()->password(8),
            'password_confirmation' => '',
            'name' => fake()->name()
        ]],
    'password mismatch' =>
        [[
            'email' => fake()->unique()->safeEmail(),
            'password' => fake()->password(8),
            'password_confirmation' => fake()->password(8),
            'name' => fake()->name()
        ]],
    'empty name' =>
        [[
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password1!',
            'password_confirmation' => 'password1!',
            'name' => ''
        ]],
]);
