<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Создаем тестового пользователя
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);

        // Создаем тестовый токен
        $this->token = $this->user->createToken('test-token')->plainTextToken;
    }

    public function test_user_can_create_task()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/tasks', [
            'title' => 'Test Task',
            'description' => 'Test Description'
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'title',
                'description',
                'status',
                'user_id',
                'created_at'
            ])
            ->assertJson([
                'title' => 'Test Task',
                'status' => 'new'
            ]);
    }

    public function test_user_cannot_update_others_task()
    {
        $otherUser = User::factory()->create();
        $task = Task::factory()->forUser($otherUser)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Title'
        ]);

        $response->assertForbidden();
    }

    public function test_task_has_default_status()
    {
        $task = Task::factory()->forUser($this->user)->create([
        ]);

        $this->assertEquals('new', $task->status);
    }
}