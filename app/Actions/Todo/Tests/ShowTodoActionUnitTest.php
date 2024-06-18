<?php

use App\Actions\Todo\ShowTodoAction;
use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'todo', 'show');

beforeEach(function () {

    $this->repository = Mockery::mock(TodoRepositoryInterface::class);
    $this->action = new ShowTodoAction($this->repository);
});

test('todo action success with update', function () {
    $model = Todo::factory()
        ->withID(1)
        ->make();

    $this->repository->expects('show')
        ->andReturn($model);

    $response = $this->action->execute($model->id);
    expect($response)->toEqual($model);
});
