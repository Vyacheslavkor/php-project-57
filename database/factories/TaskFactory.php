<?php

namespace Database\Factories;

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
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ];
    }
}
