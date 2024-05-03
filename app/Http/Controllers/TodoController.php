<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $todos = Todo::all();
        return TodoResource::collection($todos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request): TodoResource
    {
        $data = $request->validated();
        $todo = Todo::create($data);
        return new TodoResource($todo);
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo): TodoResource
    {
        return new TodoResource($todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, Todo $todo): TodoResource
    {
        $data = $request->validated();
        $todo->update($data);
        return new TodoResource($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return new TodoResource($todo);
    }
}
