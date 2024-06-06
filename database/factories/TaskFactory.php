<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'todo_id' => Todo::factory(),
            'title' => $this->faker->title,
            'description' => $this->faker->optional()->text,
            'is_active' => $this->faker->boolean,
            'estimation' => $this->faker->optional()->date,
        ];
    }

    public function withID(int $id): self
    {
        return $this->state([
            'id' => $id
        ]);
    }
}
