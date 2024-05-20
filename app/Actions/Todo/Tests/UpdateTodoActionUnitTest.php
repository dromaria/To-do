<?php

use App\Actions\Todo\UpdateTodoAction;
use App\DTO\Todo\UpdateTodoDTO;
use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'todo', 'update');

beforeEach(function () {

    $this->repository = Mockery::mock(TodoRepositoryInterface::class);
    $this->action = new UpdateTodoAction($this->repository);
});

test('todo action success with update', function () {
    $model = Todo::factory()
        ->withID(1)
        ->make();
    $dto = new UpdateTodoDTO;

    $this->repository->expects('update')
        ->andReturn($model);

    $response = $this->action->execute($model->id, $dto);
    expect($response)->toEqual($model);
});
