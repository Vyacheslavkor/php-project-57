<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get(route('labels.index'));

        $response->assertOk();
    }

    public function testCreate()
    {
        $createRoute = route('labels.create');

        $response = $this->get($createRoute);
        $response->assertRedirect(route('login'));

        $user = User::factory()->make();

        $response = $this->actingAs($user)->get($createRoute);
        $response->assertOk();
    }

    public function testEdit()
    {
        $label = Label::factory()->create();
        $editRoute = route('labels.edit', $label);

        $response = $this->get($editRoute);
        $response->assertRedirect(route('login'));

        $user = User::factory()->make();

        $response = $this->actingAs($user)->get($editRoute);
        $response->assertOk();
    }

    public function testStore()
    {
        $label = Label::factory()->make();
        $data = $label->toArray();
        $storeRoute = route('labels.store');

        $response = $this->post($storeRoute, $data);
        $response->assertRedirect('login');

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post($storeRoute, $data);
        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', $data);
    }

    public function testUpdate()
    {
        $label = Label::factory()->create();
        $updateRoute = route('labels.update', $label);

        $label->description = fake()->paragraph;
        $data = $label->toArray();
        unset($data['created_at'], $data['updated_at']);

        $response = $this->patch($updateRoute, $data);
        $response->assertRedirect('login');

        $user = User::factory()->make();

        $response = $this->actingAs($user)->patch($updateRoute, $data);
        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('labels', $data);
    }

    public function testDestroy()
    {
        $label = Label::factory()->create();
        $destroyRoute = route('labels.destroy', $label);
        $user = User::factory()->make();

        $response = $this->delete($destroyRoute);
        $response->assertRedirect('login');

        $response = $this->actingAs($user)->delete($destroyRoute);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseMissing('labels', $label->only('id'));

        $task = Task::factory()->withLabels(1)->create();
        $linkedLabel = $task->labels->first();

        $response = $this->actingAs($user)->delete(route('labels.destroy', $linkedLabel));

        $response->assertRedirect(route('labels.index', ['error' => 'has_linked_tasks']));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', $linkedLabel->only('id'));
    }
}
