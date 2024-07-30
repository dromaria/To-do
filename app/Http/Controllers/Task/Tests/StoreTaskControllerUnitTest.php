<?php


use App\Actions\Task\StoreTaskAction;
use App\Actions\Todo\ShowTodoAction;
use App\DTO\Task\StoreTaskDTO;
use App\Models\Task;
use App\Models\User;
use Tests\UnitTestCase;
use function Pest\Laravel\post;

uses(UnitTestCase::class)
->group('unit', 'controller', 'task', 'store');

beforeEach(function () {
    $this->action = Mockery::mock(StoreTaskAction::class);
    $this->app->instance(StoreTaskAction::class, $this->action);
});

test('POST /todos/{id}/tasks: 200', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $data = Task::factory()
        ->withID(1)
        ->recycle($user)
        ->make(['todo_id' => fake()->randomNumber()]);

    $modelDTO = new StoreTaskDTO(
        [
        'todo_id'  => $data->todo_id,
        'title' => $data->title,
        'description' => $data->description,
        'is_active' => $data->is_active,
        'estimation' => $data->estimation
        ]
    );

    $showTodoAction = Mockery::mock(ShowTodoAction::class);
    $this->app->instance(ShowTodoAction::class, $showTodoAction);

    $this->action->expects('execute')
        ->with(Mockery::mustBe($modelDTO), $showTodoAction)
        ->andReturn($data);

    post(
        'api/todos/' . $data->todo_id . '/tasks',
        [
        'title' => $data->title,
        'description' => $data->description,
        'is_active' => $data->is_active,
        'estimation' => $data->estimation
        ],
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

test('POST /todos/{id}/tasks: 422', function (array $request) {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $this->action->expects('execute')
        ->never();

    post('api/todos/1/tasks', $request, ['Authorization' => 'Bearer' . $token])->assertStatus(422);
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
