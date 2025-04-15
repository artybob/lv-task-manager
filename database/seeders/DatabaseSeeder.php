<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Сначала создаем тестового пользователя
        $testUser = User::create([
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // Затем создаем задачи для него
        Task::factory()
            ->count(10)
            ->create(['user_id' => $testUser->id]);

        // Создаем дополнительных пользователей с задачами
        User::factory()
            ->count(5)
            ->has(
                Task::factory()->count(3),
                'tasks' // Указываем отношение
            )
            ->create();
    }
}