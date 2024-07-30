<?php


use App\Actions\Task\StoreTaskAction;
use App\Actions\Todo\ShowTodoAction;
use App\DTO\Task\StoreTaskDTO;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
->group('unit', 'action', 'task', 'store');

beforeEach(function () {
    $this->repository = Mockery::mock(TaskRepositoryInterface::class);
    $this->action = new StoreTaskAction($this->repository);
});

test('task action success with create', function () {


    $model = Task::factory()
        ->withID(1)
        ->make(['todo_id' => fake()->randomNumber()]);

    $dto = new StoreTaskDTO(['todo_id' => $model->todo_id]);

    $showTodoAction = Mockery::mock(ShowTodoAction::class);
    $showTodoAction->expects('execute')->with($model->todo_id);

    $this->repository->expects('store')->andReturn($model);

    $response = $this->action->execute($dto, $showTodoAction);
    expect($response)->toEqual($model);
});
