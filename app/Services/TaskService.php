<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Repositories\Contracts\TaskRepositoryInterface;

class TaskService
{
    public function __construct(TaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getUserTasks(User $user, ?string $status = null)
    {
        return $this->repository->getForUser($user, $status);
    }

    public function createTask(User $user, array $data): Task
    {
        return $this->repository->createForUser($user, [
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 'new'
        ]);
    }

    public function updateTask(Task $task, array $data): bool
    {
        return $this->repository->update($task, [
            'title' => $data['title'] ?? $task->title,
            'description' => $data['description'] ?? $task->description,
            'status' => $data['status'] ?? $task->status
        ]);
    }

    public function deleteTask(Task $task): bool
    {
        return $this->repository->delete($task);
    }
}