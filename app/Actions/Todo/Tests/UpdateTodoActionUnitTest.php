<?php

use App\Actions\Todo\UpdateTodoAction;
use App\DTO\Todo\UpdateTodoDTO;
use App\Models\Todo;
use App\Models\User;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'todo', 'update');

beforeEach(function () {

    $this->repository = Mockery::mock(TodoRepositoryInterface::class);
    $this->action = new UpdateTodoAction($this->repository);
});

test('todo action success with update', function () {

    $userMock = Mockery::mock(User::class);
    $userMock->shouldReceive('getAttribute')->with('id')->andReturn(fake()->randomNumber());

    $model = Todo::factory()
        ->withID(1)
        ->make(['user_id' => $userMock->id]);
    $dto = new UpdateTodoDTO;

    Auth::shouldReceive('user')->andReturn($userMock);

    $userMock->expects('cannot')
        ->with('check', [Todo::class, $model->user_id])
        ->andReturn(false);

    $this->repository->expects('show')
        ->andReturn($model);

    $this->repository->expects('update')
        ->andReturn($model);

    $response = $this->action->execute($model->id, $dto);
    expect($response)->toEqual($model);
});
