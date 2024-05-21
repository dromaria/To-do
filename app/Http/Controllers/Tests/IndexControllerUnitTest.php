<?php

use App\Actions\Todo\IndexTodoAction;
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

    $data = Todo::factory()
        ->make([
            'id' => fake()->randomNumber()
        ]);

    $this->action->expects('execute')
        ->withAnyArgs()
        ->andReturn(collect([$data]));

    get('/api/todos/')
        ->assertOk()
        ->assertJson(
            [
                'data' => [
                    [
                        'id' => $data->id,
                        'title' => $data->title,
                        'description' => $data->description,
                    ]
                ]
            ]
        );
});
