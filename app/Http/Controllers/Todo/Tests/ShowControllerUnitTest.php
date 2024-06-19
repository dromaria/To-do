<?php

use App\Actions\Todo\ShowTodoAction;
use App\Models\Todo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\UnitTestCase;
use function Pest\Laravel\get;

uses(UnitTestCase::class)
    ->group('unit', 'controller', 'todo', 'show');

beforeEach(function () {
    $this->action = Mockery::mock(ShowTodoAction::class);
    $this->app->instance(ShowTodoAction::class, $this->action);
});


test('GET /todos/{id}: 200', function () {
    $data = Todo::factory()
        ->withID(1)
        ->make();

    $this->action->expects('execute')
        ->with($data->id)
        ->andReturn($data);

    get('/api/todos/' . $data->id)->assertOk()
        ->assertJson(
            ['data' => [
                'id' => $data->id,
                'title' => $data->title,
                'description' => $data->description,
            ]]
        );
});

test('GET /todos/{id}: 404', function () {

    $this->action->expects('execute')
        ->andThrow(ModelNotFoundException::class);

    get('/api/todos/1')
        ->assertStatus(404);
});
