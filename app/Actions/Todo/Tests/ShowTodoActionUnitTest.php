<?php

use App\Actions\Todo\ShowTodoAction;
use App\Models\Todo;
use App\Models\User;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'todo', 'show');

beforeEach(function () {

    $this->repository = Mockery::mock(TodoRepositoryInterface::class);
    $this->action = new ShowTodoAction($this->repository);
});

test('todo action success with update', function () {

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

    $response = $this->action->execute($model->id);
    expect($response)->toEqual($model);
});
