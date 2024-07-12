<?php

use App\Actions\Todo\IndexTodoAction;
use App\DTO\Pagination\PaginationDTO;
use App\Models\Todo;
use App\Models\User;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'todo', 'index');

beforeEach(function () {

    $this->repository = Mockery::mock(TodoRepositoryInterface::class);
    $this->action = new IndexTodoAction($this->repository);
});

test('todo action success with index', function () {

    $userMock = Mockery::mock(User::class);
    $userMock->shouldReceive('getAttribute')->with('id')->andReturn(fake()->randomNumber());

    $model = Todo::factory()
        ->withID(1)
        ->make(['user_id' => $userMock->id]);
    $dto = new PaginationDTO();

    Auth::shouldReceive('user')->andReturn($userMock);

    $userMock->expects('getAuthIdentifier')
        ->andReturn($userMock->id);

    $this->repository->expects('index')
        ->andReturn(collect($model));

    $response = $this->action->execute($dto);
    expect($response)->toEqual(collect($model));
});
