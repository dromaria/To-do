<?php


use App\Actions\Task\DestroyTaskAction;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\UnitTestCase;
use function Pest\Laravel\delete;

uses(UnitTestCase::class)
->group('unit', 'action', 'controller', 'destroy');

beforeEach(function () {
    $this->action = Mockery::mock(DestroyTaskAction::class);
    $this->app->instance(DestroyTaskAction::class, $this->action);
});

test('DELETE /todos/tasks/{id}: 200', function () {

    $data = Task::factory()
        ->withID(1)
        ->make(['todo_id' => fake()->randomNumber()]);

    $this->action->expects('execute')
        ->with($data->id)
        ->andReturnNull();

    delete(
        'api/todos/tasks/' . $data->id,
        [
        'title' => $data->title,
        'description' => $data->description,
        'is_active' => $data->is_active,
        'estimation' => $data->estimation
        ]
    )->assertOk();
});

test('DELETE /todos/tasks/{id}: 404', function () {

    $this->action->expects('execute')
        ->andThrow(ModelNotFoundException::class);

    delete('api/todos/tasks/1')->assertStatus(404);
});
