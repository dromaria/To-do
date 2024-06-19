<?php


use App\Actions\Task\StoreTaskAction;
use App\DTO\Task\StoreTaskDTO;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
->group('unit', 'action', 'task', 'store');

beforeEach(function () {
    $this->taskRepository = Mockery::mock(TaskRepositoryInterface::class);
    $this->todoRepository = Mockery::mock(TodoRepositoryInterface::class);
    $this->action = new StoreTaskAction($this->taskRepository, $this->todoRepository);
});

test('task action success with create', function () {

    $model = Task::factory()
        ->withID(1)
        ->make(['todo_id' => fake()->randomNumber()]);

    $dto = new StoreTaskDTO(['todo_id' => $model->todo_id]);

    $this->todoRepository->expects('show');
    $this->taskRepository->expects('store')->andReturn($model);

    $response = $this->action->execute($dto);
    expect($response)->toEqual($model);
});
