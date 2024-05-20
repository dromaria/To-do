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

    $todoMock = Mockery::mock(Todo::class);

    $todoMock->shouldReceive('getAttribute')->with('id')->andReturn($data->id);
    $todoMock->shouldReceive('getAttribute')->with('title')->andReturn($data->title);
    $todoMock->shouldReceive('getAttribute')->with('description')->andReturn($data->description);

    $todoMock->shouldReceive('resolveRouteBinding')->andReturn($todoMock);

    $this->app->instance(Todo::class, $todoMock);

    $this->action->expects('execute')
        ->withAnyArgs()
        ->andReturn(collect([$todoMock]));

    get('/api/todos/')->assertOk()
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

/*test('PATCH /todos/{id}: 422', function (array $request) {

    $todoMock = Mockery::mock(Todo::class);
    $todoMock->shouldReceive('getAttribute')->with('id')->andReturn(1);
    $todoMock->shouldReceive('getAttribute')->with('title')->andReturn($request['title']);
    $todoMock->shouldReceive('getAttribute')->with('description')->andReturn($request['description']);

    $todoMock->shouldReceive('resolveRouteBinding')->andReturn($todoMock);

    $this->app->instance(Todo::class, $todoMock);

    $this->action->expects('execute')
        ->never();

    patch('/api/todos/1', $request)
        ->assertStatus(422);
})->with([
    'empty data' => [
        ['title'=>'', 'description'=>'']
    ],
    'empty title' => [
        ['title'=>'','description'=>fake()->optional()->text]
    ]]);

test('PATCH /todos/{id}: 404', function () {

    $this->action->expects('execute')
        ->never();

    patch('/api/todos/1', [
        'title' => fake()->title,
        'description' => fake()->text
    ])
        ->assertStatus(404);
});*/
