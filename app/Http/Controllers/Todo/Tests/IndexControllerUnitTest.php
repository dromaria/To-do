<?php

use App\Actions\Todo\IndexTodoAction;
use App\DTO\Pagination\PaginationDTO;
use App\Models\Todo;
use App\Models\User;
use Tests\UnitTestCase;
use function Pest\Laravel\get;

uses(UnitTestCase::class)
    ->group('unit', 'controller', 'todo', 'index');

beforeEach(function () {
    $this->action = Mockery::mock(IndexTodoAction::class);
    $this->app->instance(IndexTodoAction::class, $this->action);
});


test('GET /todos/: 200', function () {

    $user = User::factory()
        ->withID(1)
        ->make();

    $token = JWTAuth::fromUser($user);

    $modelData = Todo::factory()
        ->for($user)
        ->make([
            'id' => fake()->randomNumber()
        ]);

    $paginationData = new PaginationDTO(['limit' => 10, 'offset' => 1]);

    $this->action->expects('execute')
        ->with(Mockery::mustBe($paginationData))
        ->andReturn(collect([$modelData]));

    get('/api/todos/', ['Authorization' => 'Bearer ' . $token])
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
