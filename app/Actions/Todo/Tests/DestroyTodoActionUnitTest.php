<?php

use App\Actions\Todo\DestroyTodoAction;
use App\Models\Todo;
use App\Models\User;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'todo', 'destroy');

beforeEach(function () {
    $this->repository = Mockery::mock(TodoRepositoryInterface::class);
    $this->action = new DestroyTodoAction($this->repository);
});

test('todo action success with destroy', function () {

    $userMock = Mockery::mock(User::class);
    $userMock->shouldReceive('getAttribute')->with('id')->andReturn(fake()->randomNumber());

    $model = Todo::factory()
        ->withID(1)
        ->make(['user_id' => $userMock->id]);

    Auth::shouldReceive('user')->andReturn($userMock);

    $userMock->expects('cannot')
        ->with('check', [Todo::class, $model->user_id])
        ->andReturn(false);

    $this->repository->expects('show')
        ->andReturn($model);

    $this->repository->expects('destroy')
        ->andReturnNull();

    $response = $this->action->execute($model->id);
    expect($response)->toBeNull();
});
