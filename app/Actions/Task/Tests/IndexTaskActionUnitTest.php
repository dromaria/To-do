<?php


use App\Actions\Task\IndexTaskAction;
use App\DTO\Pagination\PaginationDTO;
use App\Models\Task;
use App\Models\Todo;
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

    $this->repository->expects('index')->andReturn(collect($modelTask));

    $response = $this->action->execute($dto, $modelTask->todo_id);
    expect($response)->toEqual(collect($modelTask));
});
