<?php


use App\Actions\Task\StoreTaskAction;
use App\DTO\Task\StoreTaskDTO;
use App\Models\Task;
use Tests\UnitTestCase;
use function Pest\Laravel\post;

uses(UnitTestCase::class)
->group('unit', 'action', 'controller', 'store');

beforeEach(function () {
    $this->action = Mockery::mock(StoreTaskAction::class);
    $this->app->instance(StoreTaskAction::class, $this->action);
});

test('POST /todos/{id}/tasks: 200', function () {

    $data = Task::factory()
        ->withID(1)
        ->make();

    $modelDTO = new StoreTaskDTO(
        [
        'todo_id'  => $data->todo_id,
        'title' => $data->title,
        'description' => $data->description,
        'state' => $data->state,
        'estimation' => $data->estimation
        ]
    );

    $this->action->expects('execute')
        ->with(Mockery::mustBe($modelDTO))
        ->andReturn($data);

    post(
        'api/todos/' . $data->todo_id . '/tasks',
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

test('POST /todos/{id}/tasks: 422', function (array $request) {

    $this->action->expects('execute')
        ->never();

    post('api/todos/1/tasks', $request)->assertStatus(422);
})->with([
    'empty data' => [
        []
    ],
    'empty title' => [
        [
            'description' => fake()->optional()->text
        ]
    ]
]);
