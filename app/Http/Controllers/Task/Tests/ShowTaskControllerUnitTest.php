<?php

use App\Actions\Task\ShowTaskAction;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\UnitTestCase;
use function Pest\Laravel\get;

uses(UnitTestCase::class)
->group('unit', 'controller', 'task', 'show');

beforeEach(function () {
    $this->action = Mockery::mock(ShowTaskAction::class);
    $this->app->instance(ShowTaskAction::class, $this->action);
});

test('GET /todos/tasks/{id}: 200', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $data = Task::factory()
        ->withID(1)
        ->recycle($user)
        ->make(['todo_id' => fake()->randomNumber()]);

    $this->action->expects('execute')
        ->with($data->id)
        ->andReturn($data);

    get(
        'api/todos/tasks/' . $data->id,
        ['Authorization' => 'Bearer ' . $token]
    )->assertOk()
        ->assertJson([
            'data' =>
                [
                    'id' => $data->id,
                    'todo_id' => $data->todo_id,
                    'title' => $data->title,
                    'description' => $data->description,
                    'is_active' => $data->is_active,
                    'estimation' => $data->estimation
                ]
        ]);
});

test('GET /todos/tasks/{id}: 404', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $this->action->expects('execute')
        ->andThrow(ModelNotFoundException::class);

    get('api/todos/tasks/1', [
        'Authorization' => 'Bearer ' . $token
    ])->assertStatus(404);
});
