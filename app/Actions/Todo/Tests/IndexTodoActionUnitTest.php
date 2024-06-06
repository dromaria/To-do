<?php

use App\Actions\Todo\IndexTodoAction;
use App\DTO\Pagination\PaginationDTO;
use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Tests\UnitTestCase;

uses(UnitTestCase::class)
    ->group('unit', 'action', 'todo', 'index');

beforeEach(function () {

    $this->repository = Mockery::mock(TodoRepositoryInterface::class);
    $this->action = new IndexTodoAction($this->repository);
});

test('todo action success with index', function () {
    $model = Todo::factory()
        ->withID(1)
        ->make();
    $dto = new PaginationDTO();

    $this->repository->expects('index')
        ->andReturn(collect($model));

    $response = $this->action->execute($dto);
    expect($response)->toEqual(collect($model));
});
