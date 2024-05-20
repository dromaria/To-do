<?php

use App\Actions\Todo\DestroyTodoAction;
use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'todo', 'destroy');

beforeEach(function () {
    $this->repository = Mockery::mock(TodoRepositoryInterface::class);
    $this->action = new DestroyTodoAction($this->repository);
});

test('todo action success with destroy', function () {
    /** @var Todo $model */
    $model = Todo::factory()
        ->withID(1)
        ->make();

    $this->repository->expects('destroy')
        ->andReturn($model);

    /** @var Todo $response */
    $response = $this->action->execute($model);
    expect($response)->toEqual($model);
});
