<?php

namespace App\Repositories;

use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TodoRepositories implements TodoRepositoryInterface
{
    public function index(): Collection|Todo
    {
        return Todo::all();
    }

    public function store($data): Model|Todo
    {
        return Todo::create($data);
    }

    public function update($todo, $data): Model|Todo
    {
        $todo->update($data);
        return $todo;
    }
    public function destroy($todo): Model|Todo
    {
        $todo->delete();
        return $todo;
    }
}
