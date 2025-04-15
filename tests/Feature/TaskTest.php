<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/tasks', [
            'title' => 'Test Task',
            'description' => 'Test Description'
        ]);

        $response->assertStatus(201)
            ->assertJson(['title' => 'Test Task']);
    }

    public function test_user_cannot_update_others_task()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user1->id]);

        $this->actingAs($user2);

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Title'
        ]);

        $response->assertForbidden();
    }

    public function test_task_creation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/tasks', [
            'title' => 'Test Task'
        ]);

        $response->assertJsonFragment([
            'title' => 'Test Task',
            'status' => 'new'
        ]);
    }
}