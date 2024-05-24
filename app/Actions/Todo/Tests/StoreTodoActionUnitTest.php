<?php

use App\Actions\Todo\StoreTodoAction;
use App\DTO\Todo\StoreTodoDTO;
use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'todo', 'store');

beforeEach(function () {

    $this->repository = Mockery::mock(TodoRepositoryInterface::class);
    $this->action = new StoreTodoAction($this->repository);
});

test('todo action success with create', function () {
    $model = Todo::factory()
        ->withID(1)
        ->make();
    $dto = new StoreTodoDTO;

    $this->repository->expects('store')
        ->andReturn($model);

    $response = $this->action->execute($dto);
    expect($response)->toEqual($model);
});
