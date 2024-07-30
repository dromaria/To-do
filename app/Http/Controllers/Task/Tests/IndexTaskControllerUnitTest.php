<?php


use App\Actions\Task\IndexTaskAction;
use App\Actions\Todo\ShowTodoAction;
use App\DTO\Pagination\PaginationDTO;
use App\Models\Task;
use App\Models\User;
use Tests\UnitTestCase;
use function Pest\Laravel\get;

uses(UnitTestCase::class)
->group('unit', 'controller', 'task', 'index');

beforeEach(function () {
    $this->action = Mockery::mock(IndexTaskAction::class);
    $this->app->instance(IndexTaskAction::class, $this->action);
});

test('GET /todos/{id}/tasks: 200', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $modelData = Task::factory()
        ->recycle($user)
        ->make(['id' => fake()->randomNumber(), 'todo_id' => fake()->randomNumber()]);

    $paginationData = new PaginationDTO(['limit' => 10, 'offset' => 1]);

    $showTodoAction = Mockery::mock(ShowTodoAction::class);
    $this->app->instance(ShowTodoAction::class, $showTodoAction);

    $this->action->expects('execute')
        ->with(Mockery::mustBe($paginationData), $modelData->todo_id, $showTodoAction)
        ->andReturn(collect([$modelData]));

    get('api/todos/' . $modelData->todo_id . '/tasks', ['Authorization' => 'Bearer ' . $token])
        ->assertOk()
        ->assertJson([
            'data' =>
                [[
                    'id' => $modelData->id,
                    'todo_id' => $modelData->todo_id,
                    'title' => $modelData->title,
                    'description' => $modelData->description,
                    'is_active' => $modelData->is_active,
                    'estimation' => $modelData->estimation
                ]]
        ]);
});
