<?php


use App\Actions\Task\IndexTaskAction;
use App\DTO\Pagination\PaginationDTO;
use App\Models\Task;
use Tests\UnitTestCase;
use function Pest\Laravel\get;

uses(UnitTestCase::class)
->group('unit', 'action', 'controller', 'index');

beforeEach(function () {
    $this->action = Mockery::mock(IndexTaskAction::class);
    $this->app->instance(IndexTaskAction::class, $this->action);
});

test('GET /todos/{id}/tasks: 200', function () {

    $modelData = Task::factory()
        ->make(['id' => fake()->randomNumber()]);

    $paginationData = new PaginationDTO(['limit' => 10, 'offset' => 1]);

    $this->action->expects('execute')
        ->with(Mockery::mustBe($paginationData), $modelData->todo_id)
        ->andReturn(collect([$modelData]));

    get('api/todos/' . $modelData->todo_id . '/tasks')
        ->assertOk()
        ->assertJson([
            'data' =>
                [[
                    'id' => $modelData->id,
                    'todo_id' => $modelData->todo_id,
                    'title' => $modelData->title,
                    'description' => $modelData->description,
                    'state' => $modelData->state,
                    'estimation' => $modelData->estimation
                ]]
        ]);
});
