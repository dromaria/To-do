<?php


use App\Actions\Task\IndexTaskAction;
use App\Actions\Todo\ShowTodoAction;
use App\DTO\Pagination\PaginationDTO;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
->group('unit', 'action', 'task', 'index');

beforeEach(function () {
    $this->repository = Mockery::mock(TaskRepositoryInterface::class);
    $this->action = new IndexTaskAction($this->repository);
});

test('task action success with index', function () {

    $modelTask = Task::factory()
        ->withID(1)
        ->make(['todo_id' => fake()->randomNumber()]);

    $dto = new PaginationDTO();

    $showTodoAction = Mockery::mock(ShowTodoAction::class);
    $showTodoAction->expects('execute')->with($modelTask->todo_id);

    $this->repository->expects('index')->andReturn(collect($modelTask));

    $response = $this->action->execute($dto, $modelTask->todo_id, $showTodoAction);
    expect($response)->toEqual(collect($modelTask));
});
