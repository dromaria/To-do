<?php

namespace App\Repositories\Interfaces;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface TodoRepositoryInterface
{
    public function index(): Collection|Todo;
    public function store($data): Model|Todo;
    public function update($todo, $data): Model|Todo;
    public function destroy($todo): Model|Todo;
}
