<?php


use App\Actions\Task\DestroyTaskAction;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\UnitTestCase;
use function Pest\Laravel\delete;

uses(UnitTestCase::class)
->group('unit', 'controller', 'task', 'destroy');

beforeEach(function () {
    $this->action = Mockery::mock(DestroyTaskAction::class);
    $this->app->instance(DestroyTaskAction::class, $this->action);
});

test('DELETE /todos/tasks/{id}: 200', function () {

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
        ->andReturnNull();

    delete(
        'api/todos/tasks/' . $data->id,
        headers: ['Authorization' => 'Bearer ' . $token]
    )->assertOk();
});

test('DELETE /todos/tasks/{id}: 404', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $this->action->expects('execute')
        ->andThrow(ModelNotFoundException::class);

    delete('api/todos/tasks/1', headers: ['Authorization' => 'Bearer ' . $token])->assertStatus(404);
});
