<?php

use App\Actions\Todo\UpdateTodoAction;
use App\DTO\Todo\UpdateTodoDTO;
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

    $modelDTO = new UpdateTodoDTO(['title' => $data->title, 'description' => $data->description]);

    $this->action->expects('execute')
        ->with(Mockery::mustBe($modelDTO))
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
        ->andThrow(ModelNotFoundException::class);

    patch('/api/todos/1', [
        'title' => fake()->title,
        'description' => fake()->text
    ])
        ->assertStatus(404);
});
