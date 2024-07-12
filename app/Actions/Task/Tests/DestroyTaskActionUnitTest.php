<?php


use App\Actions\Task\DestroyTaskAction;
use App\Models\Task;
use App\Models\Todo;
use App\Models\User;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
->group('unit', 'action', 'task', 'destroy');

beforeEach(function () {
    $this->repository = Mockery::mock(TaskRepositoryInterface::class);
    $this->action = new DestroyTaskAction($this->repository);
});

test('task action success with delete', function () {

    $userMock = Mockery::mock(User::class);
    $userMock->shouldReceive('getAttribute')->with('id')->andReturn(fake()->randomNumber());

    $todoMock = Mockery::mock(Todo::class);
    $todoMock->shouldReceive('getAttribute')->with('id')->andReturn(fake()->randomNumber());
    $todoMock->shouldReceive('getAttribute')->with('user_id')->andReturn($userMock->id);

    $model = Task::factory()
        ->withID(1)
        ->make(['todo_id' => $todoMock->id]);

    $model->setRelation('todo', $todoMock);

    $this->repository->expects('findUserAndTask')->andReturn($model);

    Auth::shouldReceive('user')->andReturn($userMock);

    $userMock->expects('cannot')
        ->with('check', [Todo::class, $model->getRelation('todo')->user_id])
        ->andReturn(false);

    $this->repository->expects('destroy')->andReturnNull();

    $response = $this->action->execute($model->id);
    expect($response)->toBeNull();
});
