<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->make();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertRedirect(route('login'));

        $response = $this->actingAs($this->user)->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $taskStatus = TaskStatus::factory()->create();

        $response = $this->get(route('task_statuses.edit', $taskStatus));
        $response->assertRedirect(route('login'));

        $response = $this->actingAs($this->user)->get(route('task_statuses.edit', $taskStatus));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $data = TaskStatus::factory()->make()->only('name');

        $response = $this->post(route('task_statuses.store'), $data);
        $response->assertRedirect(route('login'));

        $response = $this->actingAs($this->user)->post(route('task_statuses.store'), $data);
        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHasNoErrors();

        /** @var array $data */
        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testUpdate(): void
    {
        $taskStatus = TaskStatus::factory()->create();
        $data = TaskStatus::factory()->make()->only('name');

        $response = $this->patch(route('task_statuses.update', $taskStatus), $data);
        $response->assertRedirect(route('login'));

        $response = $this->actingAs($this->user)->patch(route('task_statuses.update', $taskStatus), $data);

        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHasNoErrors();

        /** @var array $data */
        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testDestroy(): void
    {
        $taskStatus = TaskStatus::factory()->create();

        $response = $this->delete(route('task_statuses.destroy', [$taskStatus]));
        $response->assertRedirect(route('login'));

        /** @var Task $task */
        $task = Task::factory()->create();
        $response = $this->actingAs($task->creator)->delete(route('task_statuses.destroy', $task->status));
        $response->assertRedirect(route('task_statuses.index', ['error' => 'used_in_tasks']));

        $response = $this->actingAs($this->user)->delete(route('task_statuses.destroy', $taskStatus));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));

        /** @var array $data */
        $data = $taskStatus->only('id');
        $this->assertDatabaseMissing('task_statuses', $data);
    }
}
