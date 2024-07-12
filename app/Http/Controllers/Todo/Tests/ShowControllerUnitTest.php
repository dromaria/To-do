<?php

use App\Actions\Todo\ShowTodoAction;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\UnitTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use function Pest\Laravel\get;

uses(UnitTestCase::class)
    ->group('unit', 'controller', 'todo', 'show');

beforeEach(function () {
    $this->action = Mockery::mock(ShowTodoAction::class);
    $this->app->instance(ShowTodoAction::class, $this->action);
});


test('GET /todos/{id}: 200', function () {

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
        ->andReturn($data);


    get('/api/todos/' . $data->id, ['Authorization' => 'Bearer ' . $token])
        ->assertOk()
        ->assertJson(
            ['data' => [
                'id' => $data->id,
                'title' => $data->title,
                'description' => $data->description,
            ]]
        );
});

test('GET /todos/{id}: 404', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $this->action->expects('execute')
        ->andThrow(ModelNotFoundException::class);

    get('/api/todos/1', ['Authorization' => 'Bearer ' . $token])
        ->assertStatus(404);
});
