<?php


use App\Actions\Task\ShowTaskAction;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
->group('unit', 'action', 'task', 'show');

beforeEach(function () {
    $this->repository = Mockery::mock(TaskRepositoryInterface::class);
    $this->action = new ShowTaskAction($this->repository);
});

test('task action success with show', function () {

    $model = Task::factory()
        ->withID(1)
        ->make();

    $this->repository->expects('show')->andReturn($model);

    $response = $this->action->execute($model->id);
    expect($response)->toEqual($model);
});
