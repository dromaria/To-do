<?php


use App\Actions\Task\UpdateTaskAction;
use App\DTO\Task\UpdateTaskDTO;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\UnitTestCase;
use function Pest\Laravel\patch;

uses(UnitTestCase::class)
->group('unit', 'action', 'controller', 'update');

beforeEach(function () {
    $this->action = Mockery::mock(UpdateTaskAction::class);
    $this->app->instance(UpdateTaskAction::class, $this->action);
});

test('PATCH /todos/{id}/tasks/{id}: 200', function () {

    $data = Task::factory()
        ->withID(1)
        ->make();

    $modelDTO = new UpdateTaskDTO(
        [
        'title' => $data->title,
        'description' => $data->description,
        'state' => $data->state,
        'estimation' => $data->estimation
        ]
    );

    $this->action->expects('execute')
        ->with($data->id, Mockery::mustBe($modelDTO))
        ->andReturn($data);

    patch(
        'api/todos/' . $data->todo_id . '/tasks/' . $data->id,
        [
        'title' => $data->title,
        'description' => $data->description,
        'state' => $data->state,
        'estimation' => $data->estimation
        ]
    )->assertOk()
        ->assertJson([
            'data' =>
                [
                    'id' => $data->id,
                    'todo_id' => $data->todo_id,
                    'title' => $data->title,
                    'description' => $data->description,
                    'state' => $data->state,
                    'estimation' => $data->estimation
                ]
        ]);
});

test('PATCH /todos/{id}/tasks/{id}: 422', function (array $request) {

    $this->action->expects('execute')
        ->never();

    patch('api/todos/1/tasks/1', $request)->assertStatus(422);
})->with([
    'empty data' => [
        ['title' => '']
    ],
    'empty title' => [
        [
            'title' => '',
            'description' => fake()->optional()->text
        ]
    ]
]);

test('PATCH /todos/{id}/tasks/{id}: 404', function () {

    $this->action->expects('execute')
        ->andThrow(ModelNotFoundException::class);

    patch('api/todos/1/tasks/1', [
        'title' => fake()->title,
        'description' => fake()->optional()->text,
        'state' => fake()->boolean,
        'estimation' => fake()->date
    ])->assertStatus(404);
});
