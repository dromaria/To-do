<?php

use App\Actions\Todo\DestroyTodoAction;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\UnitTestCase;
use function Pest\Laravel\delete;

uses(UnitTestCase::class)
    ->group('unit', 'controller', 'todo', 'destroy');

beforeEach(function () {
    $this->action = Mockery::mock(DestroyTodoAction::class);
    $this->app->instance(DestroyTodoAction::class, $this->action);
});


test('DESTROY /todos/{id}: 200', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $data = Todo::factory()
        ->withID(1)
        ->for($user)
        ->make();

    $this->action->expects('execute')
        ->with($data->id)
        ->andReturn(response(status: 200));

    delete('/api/todos/' . $data->id, headers: ['Authorization' => 'Bearer ' . $token])
        ->assertOk();
});

test('PATCH /todos/{id}: 404', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $this->action->expects('execute')
        ->andThrow(ModelNotFoundException::class);

    delete('/api/todos/1', headers: ['Authorization' => 'Bearer ' . $token])
        ->assertStatus(404);
});
