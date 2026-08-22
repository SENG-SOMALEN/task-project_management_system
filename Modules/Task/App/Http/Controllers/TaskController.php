<?php

namespace Modules\Task\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Task\App\Services\TaskService;
use Modules\Task\App\Http\Resources\TaskResource;
use Modules\Task\App\Http\Requests\StoreTaskRequest;
use Modules\Task\App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService
    ) {}

    /**
     * Display a listing of tasks.
     */
    public function index(Request $request)
    {
        $tasks = $this->taskService->searchTask(
            $request->query('search'),
            $request->query('status')
        );

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created task.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->createTask(
            $request->validated()
        );

        return new TaskResource($task);
    }

    /**
     * Display the specified task.
     */
    public function show(int $id)
    {
        $task = $this->taskService->getTaskById($id);

        return new TaskResource($task);
    }

    /**
     * Update the specified task.
     */
    public function update(UpdateTaskRequest $request, int $id)
    {
        $task = $this->taskService->updateTask(
            $id,
            $request->validated()
        );

        return new TaskResource($task);
    }

    /**
     * Remove the specified task.
     */
    public function destroy(int $id)
    {
        $this->taskService->deleteTask($id);

        return response()->json([
            'status' => true,
            'message' => 'Task deleted successfully.',
        ]);
    }

    /**
     * Assign task to a user.
     */
    public function assign(Request $request, int $id)
    {
        $task = $this->taskService->assignTask(
            $id,
            $request->user_id
        );

        return new TaskResource($task);
    }

    /**
     * Update task priority.
     */
    public function priority(Request $request, int $id)
    {
        $task = $this->taskService->setPriority(
            $id,
            $request->priority
        );

        return new TaskResource($task);
    }

    /**
     * Update task due date.
     */
    public function dueDate(Request $request, int $id)
    {
        $task = $this->taskService->setDueDate(
            $id,
            $request->due_date
        );

        return new TaskResource($task);
    }

    /**
     * Update task Status.
     */

    public function status(Request $request, int $id)
    {
        $task = $this->taskService->updateStatus(
            $id,
            $request->status
        );

        return new TaskResource($task);
    }
}