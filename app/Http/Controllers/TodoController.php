<?php

namespace App\Http\Controllers;

use App\Actions\Todo\DestroyTodoAction;
use App\Actions\Todo\IndexTodoAction;
use App\Actions\Todo\StoreTodoAction;
use App\Actions\Todo\UpdateTodoAction;
use App\Http\Requests\Todo\StoreTodoRequest;
use App\Http\Requests\Todo\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TodoController extends Controller
{
    public function index(IndexTodoAction $indexTodoAction): ResourceCollection|TodoResource
    {
        $todos = $indexTodoAction->execute();
        return TodoResource::collection($todos);
    }

    public function store(StoreTodoRequest $request, StoreTodoAction $storeTodoAction): TodoResource
    {
        $data = $request->validated();
        $todo = $storeTodoAction->execute($data);
        return new TodoResource($todo);
    }

    public function show(Todo $todo): TodoResource
    {
        return new TodoResource($todo);
    }

    public function update(UpdateTodoRequest $request, Todo $todo, UpdateTodoAction $updateTodoAction): TodoResource
    {
        $data = $request->validated();
        $updateTodoAction->execute($todo, $data);
        return new TodoResource($todo);
    }

    public function destroy(Todo $todo, DestroyTodoAction $destroyTodoAction): TodoResource
    {
        $destroyTodoAction->execute($todo);
        return new TodoResource($todo);
    }
}
