<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }
    
    public function testCreate()
    {
        $response = $this->get(route('tasks.create'));
        $response->assertRedirect(route('login'));

        $task = Task::factory()->create();
        $creator = $task->creator;

        $response = $this->actingAs($creator)->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.edit', $task));
        $response->assertRedirect(route('login'));

        $response = $this->actingAs($task->creator)->get(route('task_statuses.edit', $task));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $task = Task::factory()->create();

        $data = [
            'assigned_to_id' => $task->assigned_to_id,
            'created_by_id'  => $task->created_by_id,
            'name'           => fake()->title(),
            'description'    => fake()->paragraph(),
            'status_id'      => $task->status_id,
        ];

        $response = $this->post(route('tasks.store'), $data);
        $response->assertRedirect(route('login'));

        $response = $this->actingAs($task->creator)->post(route('tasks.store'), $data);
        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('tasks', $data);
    }

    public function testUpdate(): void
    {
        $task = Task::factory()->create();

        $data = [
            'assigned_to_id' => $task->assigned_to_id,
            'name'           => fake()->title(),
            'description'    => fake()->paragraph(),
            'status_id'      => $task->status_id,
        ];

        $response = $this->patch(route('tasks.update', $task), $data);
        $response->assertRedirect(route('login'));

        $response = $this->actingAs($task->creator)->patch(route('tasks.update', $task), $data);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('tasks', $data);
    }

    public function testDestroy(): void
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task));
        $response->assertRedirect(route('login'));

        $new_user = User::factory()->create();

        $response = $this->actingAs($new_user)->delete(route('tasks.destroy', $task));
        $response->assertForbidden();

        $response = $this->actingAs($task->creator)->delete(route('tasks.destroy', $task));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', $task->only('id'));
    }
}
