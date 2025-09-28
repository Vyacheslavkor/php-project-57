<?php

namespace Database\Factories;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'           => $this->faker->sentence(4),
            'description'    => $this->faker->paragraph,
            'created_by_id'  => User::factory(),
            'assigned_to_id' => User::factory(),
            'status_id'      => TaskStatus::factory(),
        ];
    }

    public function withLabels(int $count = 2)
    {
        return $this->afterCreating(function (Task $task) use ($count) {
            $labels = Label::factory()->count($count)->create();
            $task->labels()->attach($labels->modelKeys());
        });
    }
}
