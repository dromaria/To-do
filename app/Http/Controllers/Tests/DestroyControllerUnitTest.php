<?php

use App\Actions\Todo\DestroyTodoAction;
use App\Models\Todo;
use Tests\UnitTestCase;
use function Pest\Laravel\delete;

uses(UnitTestCase::class)
    ->group('unit', 'controller', 'todo', 'destroy');

beforeEach(function () {
    $this->action = Mockery::mock(DestroyTodoAction::class);
    $this->app->instance(DestroyTodoAction::class, $this->action);
});


test('DESTROY /todos/{id}: 200', function () {

    $data = Todo::factory()
        ->withID(1)
        ->make();

    $todoMock = Mockery::mock(Todo::class);

    $todoMock->shouldReceive('getAttribute')->with('id')->andReturn($data->id);
    $todoMock->shouldReceive('getAttribute')->with('title')->andReturn($data->title);
    $todoMock->shouldReceive('getAttribute')->with('description')->andReturn($data->description);

    $todoMock->shouldReceive('resolveRouteBinding')->andReturn($todoMock);

    $this->app->instance(Todo::class, $todoMock);

    $this->action->expects('execute')
        ->withAnyArgs()
        ->andReturn($todoMock);

    delete('/api/todos/' . $data->id)->assertOk()
        ->assertJson(
            ['data' => [
                'id' => $data->id,
                'title' => $data->title,
                'description' => $data->description,
            ]]
        );
});

test('PATCH /todos/{id}: 404', function () {

    $this->action->expects('execute')
        ->never();

    delete('/api/todos/1')
        ->assertStatus(404);
});
