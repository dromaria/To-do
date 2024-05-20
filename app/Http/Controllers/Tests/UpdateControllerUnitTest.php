<?php

use App\Actions\Todo\UpdateTodoAction;
use App\Models\Todo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\UnitTestCase;
use function Pest\Laravel\patch;

uses(UnitTestCase::class)
    ->group('unit', 'controller', 'todo', 'update');

beforeEach(function () {
    $this->action = Mockery::mock(UpdateTodoAction::class);
    $this->app->instance(UpdateTodoAction::class, $this->action);
});


test('PATCH /todos/{id}: 200', function () {
    $data = Todo::factory()
        ->withID(1)
        ->make();

/*    $todoMock = Mockery::mock(Todo::class);
    $todoMock->shouldReceive('getAttribute')->with('id')->andReturn($data->id);
    $todoMock->shouldReceive('getAttribute')->with('title')->andReturn($data->title);
    $todoMock->shouldReceive('getAttribute')->with('description')->andReturn($data->description);
    $todoMock->shouldReceive('resolveRouteBinding')->andReturn($todoMock);

    $this->app->instance(Todo::class, $todoMock);*/

    $this->action->expects('execute')
        ->withAnyArgs()
        ->andReturn($data);

    patch('/api/todos/' . $data->id, [
        'title' => $data->title,
        'description' => $data->description,
    ])->assertOk()
        ->assertJson(
            ['data' => [
                'id' => $data->id,
                'title' => $data->title,
                'description' => $data->description,
            ]]
        );
});

test('PATCH /todos/{id}: 422', function (array $request) {

    $todoMock = \Mockery::mock(Todo::class);
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

    $this->action->expects('execute')->andThrow(ModelNotFoundException::class);

    patch('/api/todos/1', [
        'title' => fake()->title,
        'description' => fake()->text
    ])
        ->assertStatus(404);
});
