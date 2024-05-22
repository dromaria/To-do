<?php

use App\Actions\Todo\DestroyTodoAction;
use App\Models\Todo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    $this->action->expects('execute')
        ->with($data->id)
        ->andReturn(response(status: 200));

    delete('/api/todos/' . $data->id)->assertOk();
});

test('PATCH /todos/{id}: 404', function () {

    $this->action->expects('execute')
        ->andThrow(ModelNotFoundException::class);

    delete('/api/todos/1')
        ->assertStatus(404);
});
