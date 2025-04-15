<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\User;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Support\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function getForUser(User $user, ?string $status = null): Collection
    {
        return $user->tasks()
            ->when($status, fn($q) => $q->where('status', $status))
            ->get();
    }

    public function createForUser(User $user, array $data): Task
    {
        return $user->tasks()->create($data);
    }

    public function update(Task $task, array $data): bool
    {
        return $task->update($data);
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }
}