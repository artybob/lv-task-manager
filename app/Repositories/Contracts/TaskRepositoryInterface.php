<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Support\Collection;

interface TaskRepositoryInterface
{
    public function getForUser(User $user, ?string $status = null): Collection;
    public function createForUser(User $user, array $data): \App\Models\Task;
    public function update(\App\Models\Task $task, array $data): bool;
    public function delete(\App\Models\Task $task): bool;
}