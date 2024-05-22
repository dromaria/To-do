<?php

use App\Actions\Todo\IndexTodoAction;
use App\DTO\Pagination\PaginationDTO;
use App\Models\Todo;
use Tests\UnitTestCase;
use function Pest\Laravel\get;

uses(UnitTestCase::class)
    ->group('unit', 'controller', 'todo', 'index');

beforeEach(function () {
    $this->action = Mockery::mock(IndexTodoAction::class);
    $this->app->instance(IndexTodoAction::class, $this->action);
});


test('GET /todos/: 200', function () {

    $modelData = Todo::factory()
        ->make([
            'id' => fake()->randomNumber()
        ]);

    $paginationData = new PaginationDTO(['limit' => 10, 'offset' => 1]);

    $this->action->expects('execute')
        ->with(Mockery::mustBe($paginationData))
        ->andReturn(collect([$modelData]));

    get('/api/todos/')
        ->assertOk()
        ->assertJson(
            [
                'data' => [
                    [
                        'id' => $modelData->id,
                        'title' => $modelData->title,
                        'description' => $modelData->description,
                    ]
                ]
            ]
        );
});
