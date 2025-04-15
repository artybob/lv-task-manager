<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['new', 'in_progress', 'completed']),
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'created_at' => $this->faker->dateTimeBetween('-1 month'),
        ];
    }
}
