<?php


use App\Actions\Task\DestroyTaskAction;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
->group('unit', 'action', 'task', 'destroy');

beforeEach(function () {
    $this->repository = Mockery::mock(TaskRepositoryInterface::class);
    $this->action = new DestroyTaskAction($this->repository);
});

test('task action success with delete', function () {

    $model = Task::factory()
        ->withID(1)
        ->make(['todo_id' => fake()->randomNumber()]);

    $this->repository->expects('destroy')->andReturnNull();

    $response = $this->action->execute($model->id);
    expect($response)->toBeNull();
});
