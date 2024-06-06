<?php

namespace App\Http\Resources;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin Task */
class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'todo_id' => $this->todo_id,
            'title' => $this->title,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'estimation' => $this->estimation,
        ];
    }
}
