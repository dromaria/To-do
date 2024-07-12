<?php


use App\Actions\Task\UpdateTaskAction;
use App\DTO\Task\UpdateTaskDTO;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\UnitTestCase;
use function Pest\Laravel\patch;

uses(UnitTestCase::class)
->group('unit', 'controller', 'task', 'update');

beforeEach(function () {
    $this->action = Mockery::mock(UpdateTaskAction::class);
    $this->app->instance(UpdateTaskAction::class, $this->action);
});

test('PATCH /todos/tasks/{id}: 200', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $data = Task::factory()
        ->withID(1)
        ->recycle($user)
        ->make(['todo_id' => fake()->randomNumber()]);

    $modelDTO = new UpdateTaskDTO(
        [
        'title' => $data->title,
        'description' => $data->description,
        'is_active' => $data->is_active,
        'estimation' => $data->estimation
        ]
    );

    $this->action->expects('execute')
        ->with($data->id, Mockery::mustBe($modelDTO))
        ->andReturn($data);

    patch(
        'api/todos/tasks/' . $data->id,
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

test('PATCH /todos/tasks/{id}: 422', function (array $request) {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $this->action->expects('execute')
        ->never();

    patch('api/todos/tasks/1', $request, ['Authorization' => 'Bearer ' . $token])->assertStatus(422);
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

test('PATCH /todos/tasks/{id}: 404', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $this->action->expects('execute')
        ->andThrow(ModelNotFoundException::class);

    patch(
        'api/todos/tasks/1',
        [
        'title' => fake()->title,
        'description' => fake()->optional()->text,
        'is_active' => fake()->boolean,
        'estimation' => fake()->date
        ],
        ['Authorization' => 'Bearer ' . $token]
    )->assertStatus(404);
});
