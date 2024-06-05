<?php


use App\Actions\Task\UpdateTaskAction;
use App\DTO\Task\UpdateTaskDTO;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
->group('unit', 'action', 'task', 'update');

beforeEach(function () {
    $this->repository = Mockery::mock(TaskRepositoryInterface::class);
    $this->action = new UpdateTaskAction($this->repository);
});

test('task action success with update', function () {

    $model = Task::factory()
        ->withID(1)
        ->make();

    $dto = new UpdateTaskDTO();

    $this->repository->expects('update')->andReturn($model);

    $response = $this->action->execute($model->id, $dto);
    expect($response)->toEqual($model);
});
