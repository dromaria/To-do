<?php

use App\Actions\Todo\UpdateTodoAction;
use App\DTO\Todo\UpdateTodoDTO;
use App\Models\Todo;
use App\Models\User;
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

    $user = User::factory()
        ->withID(1)
        ->make();

    $data = Todo::factory()
        ->withID(1)
        ->for($user)
        ->make();

    $modelDTO = new UpdateTodoDTO(['title' => $data->title, 'description' => $data->description]);

    $this->action->expects('execute')
        ->with($data->id, Mockery::mustBe($modelDTO))
        ->andReturn($data);

    $token = JWTAuth::fromUser($user);

    patch(
        '/api/todos/' . $data->id,
        [
        'title' => $data->title,
        'description' => $data->description,
        ],
        ['Authorization' => 'Bearer ' . $token]
    )->assertOk()
        ->assertJson(
            ['data' => [
                'id' => $data->id,
                'title' => $data->title,
                'description' => $data->description,
            ]]
        );
});

test('PATCH /todos/{id}: 422', function (array $request) {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $this->action->expects('execute')
        ->never();

    patch('/api/todos/1', $request, ['Authorization' => 'Bearer' . $token])
        ->assertStatus(422);
})->with([
    'empty data' => [
        ['title'=>'', 'description'=>'']
    ],
    'empty title' => [
        ['title'=>'','description'=>fake()->optional()->text]
    ]]);

test('PATCH /todos/{id}: 404', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $this->action->expects('execute')
        ->andThrow(ModelNotFoundException::class);

    patch(
        '/api/todos/1',
        [
        'title' => fake()->title,
        'description' => fake()->text
        ],
        ['Authorization' => 'Bearer' . $token]
    )
        ->assertStatus(404);
});
