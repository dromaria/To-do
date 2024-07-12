<?php


use App\Actions\Task\UpdateTaskAction;
use App\DTO\Task\UpdateTaskDTO;
use App\Models\Task;
use App\Models\Todo;
use App\Models\User;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
->group('unit', 'action', 'task', 'update');

beforeEach(function () {
    $this->repository = Mockery::mock(TaskRepositoryInterface::class);
    $this->action = new UpdateTaskAction($this->repository);
});

test('task action success with update', function () {

    $userMock = Mockery::mock(User::class);
    $userMock->shouldReceive('getAttribute')->with('id')->andReturn(fake()->randomNumber());

    $todoMock = Mockery::mock(Todo::class);
    $todoMock->shouldReceive('getAttribute')->with('id')->andReturn(fake()->randomNumber());
    $todoMock->shouldReceive('getAttribute')->with('user_id')->andReturn($userMock->id);

    $model = Task::factory()
        ->withID(1)
        ->make(['todo_id' => $todoMock->id]);

    $dto = new UpdateTaskDTO();

    $model->setRelation('todo', $todoMock);

    $this->repository->expects('findUserAndTask')->andReturn($model);

    Auth::shouldReceive('user')->andReturn($userMock);

    $userMock->expects('cannot')
        ->with('check', [Todo::class, $model->getRelation('todo')->user_id])
        ->andReturn(false);

    $this->repository->expects('update')->andReturn($model);

    $response = $this->action->execute($model->id, $dto);
    expect($response)->toEqual($model);
});
