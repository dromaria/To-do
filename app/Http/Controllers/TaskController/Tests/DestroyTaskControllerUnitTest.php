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

test('DELETE /todos/{id}/tasks/{id}: 200', function () {

    $data = Task::factory()
        ->withID(1)
        ->make();

    $this->action->expects('execute')
        ->with($data->id)
        ->andReturnNull();

    delete(
        'api/todos/' . $data->todo_id . '/tasks/' . $data->id,
        [
        'title' => $data->title,
        'description' => $data->description,
        'state' => $data->state,
        'estimation' => $data->estimation
        ]
    )->assertOk();
});

test('DELETE /todos/{id}/tasks/{id}: 404', function () {

    $this->action->expects('execute')
        ->andThrow(ModelNotFoundException::class);

    delete('api/todos/1/tasks/1')->assertStatus(404);
});
