<?php

namespace App\Http\Controllers;

use App\Actions\Todo\DestroyTodoAction;
use App\Actions\Todo\IndexTodoAction;
use App\Actions\Todo\StoreTodoAction;
use App\Actions\Todo\UpdateTodoAction;
use App\DTO\Pagination\PaginationDTO;
use App\DTO\Todo\StoreTodoDTO;
use App\DTO\Todo\UpdateTodoDTO;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Requests\Todo\StoreTodoRequest;
use App\Http\Requests\Todo\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TodoController extends Controller
{
    public function index(
        PaginationRequest $request,
        IndexTodoAction $indexTodoAction,
    ): ResourceCollection|TodoResource {
        $data = new PaginationDTO(['limit' => $request->getLimit(), 'offset' => $request->getOffset()]);
        $todos = $indexTodoAction->execute($data);
        return TodoResource::collection($todos);
    }

    public function store(StoreTodoRequest $request, StoreTodoAction $storeTodoAction): TodoResource
    {
        $data = new StoreTodoDTO(['title' => $request->getTitle(), 'description' => $request->getDescription()]);
        $todo = $storeTodoAction->execute($data);
        return new TodoResource($todo);
    }

    public function show(Todo $todo): TodoResource
    {
        return new TodoResource($todo);
    }

    public function update(UpdateTodoRequest $request, Todo $todo, UpdateTodoAction $updateTodoAction): TodoResource
    {
        $data = new UpdateTodoDTO(array_filter([
            'title' => $request->getTitle(),
            'description' => $request->getDescription()
        ]));
        $updateTodoAction->execute($todo, $data);
        return new TodoResource($todo);
    }

    public function destroy(Todo $todo, DestroyTodoAction $destroyTodoAction): TodoResource
    {
        $destroyTodoAction->execute($todo);
        return new TodoResource($todo);
    }
}
