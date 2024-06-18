<?php

use App\Actions\Task\ShowTaskAction;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\UnitTestCase;
use function Pest\Laravel\get;

uses(UnitTestCase::class)
->group('unit', 'action', 'controller', 'show');

beforeEach(function () {
    $this->action = Mockery::mock(ShowTaskAction::class);
    $this->app->instance(ShowTaskAction::class, $this->action);
});

test('GET /todos/tasks/{id}: 200', function () {

    $data = Task::factory()
        ->withID(1)
        ->make(['todo_id' => fake()->randomNumber()]);

    $this->action->expects('execute')
        ->with($data->id)
        ->andReturn($data);

    get(
        'api/todos/tasks/' . $data->id
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

    $this->action->expects('execute')
        ->andThrow(ModelNotFoundException::class);

    get('api/todos/tasks/1', [
        'title' => fake()->title,
        'description' => fake()->optional()->text,
        'is_active' => fake()->boolean,
        'estimation' => fake()->date
    ])->assertStatus(404);
});
