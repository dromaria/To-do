<?php

use App\Actions\Todo\StoreTodoAction;
use App\DTO\Todo\StoreTodoDTO;
use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Tests\UnitTestCase;
use function Pest\Laravel\post;

uses(UnitTestCase::class)
    ->group('unit', 'controller', 'todo', 'store');


beforeEach(function () {

    $this->action = Mockery::mock(StoreTodoAction::class);
    $this->app->instance(StoreTodoAction::class, $this->action);
});

test('POST /todos: 200', function () {
    $model = Todo::factory()
        ->make([
            'id' => fake()->randomNumber(),
        ]);

    $modelDTO = new StoreTodoDTO(['title' => $model->title, 'description' => $model->description]);

    $this->action->expects('execute')
        ->with(Mockery::mustBe($modelDTO))
        ->andReturn($model);

    post('/api/todos', [
        'title' => $model->title,
        'description' => $model->description,

    ])->assertOk()
        ->assertJson([
            'data' => [
                'id' => $model->id,
                'title' => $model->title,
                'description' => $model->description,
            ]
        ]);
});

test('POST /todos: 422', function (array $request) {
    $this->action->expects('execute')
        ->never();
    post('api/todos', $request)->assertStatus(422);
})->with([
    'empty data' => [
        []
    ],
    'empty title' => [
        ['description'=>fake()->optional()->text]
    ],
])->group('post422');
