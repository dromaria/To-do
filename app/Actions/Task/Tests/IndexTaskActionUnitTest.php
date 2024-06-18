<?php


use App\Actions\Task\IndexTaskAction;
use App\DTO\Pagination\PaginationDTO;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
->group('unit', 'action', 'task', 'index');

beforeEach(function () {
    $this->taskRepository = Mockery::mock(TaskRepositoryInterface::class);
    $this->todoRepository = Mockery::mock(TodoRepositoryInterface::class);
    $this->action = new IndexTaskAction($this->taskRepository, $this->todoRepository);
});

test('task action success with index', function () {

    $modelTask = Task::factory()
        ->withID(1)
        ->make(['todo_id' => fake()->randomNumber()]);

    $dto = new PaginationDTO();

    $this->todoRepository->expects('show');
    $this->taskRepository->expects('index')->andReturn(collect($modelTask));

    $response = $this->action->execute($dto, $modelTask->todo_id);
    expect($response)->toEqual(collect($modelTask));
});
