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

    $model = Todo::factory()
        ->withID(1)
        ->make();

    $this->repository->expects('destroy')
        ->andReturnNull();

    $response = $this->action->execute($model->id);
    expect($response)->toBeNull();
});
