<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    private $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $tasks = $this->service->getUserTasks(
            Auth::user(),
            $request->status
        );

        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:new,in_progress,completed'
        ]);

        $task = $this->service->createTask(Auth::user(), $data);

        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:new,in_progress,completed'
        ]);

        $this->service->updateTask($task, $data);

        return response()->json($task->fresh());
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $this->service->deleteTask($task);

        return response()->noContent();
    }
}