<?php

namespace Modules\Task\App\Repositories;

use Modules\Task\App\Interfaces\TaskRepositoryInterface;
use Modules\Task\App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function __construct(
        private Task $task
    ) {}

    public function all()
    {
        return $this->task->all();
    }

    public function create(array $data)
    {
        return $this->task->create($data);
    }

    public function find(int $id)
    {
        return $this->task->findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $task = $this->task->findOrFail($id);

        $task->update($data);

        return $task;
    }

    public function delete(int $id)
    {
        $task = $this->task->findOrFail($id);

        return $task->delete();
    }

    public function assignTask(int $id, int $userId)
    {
        $task = $this->task->findOrFail($id);

        $task->update([
            'assigned_to' => $userId,
        ]);

        return $task;
    }

    public function setPriority(int $id, string $priority)
    {
        $task = $this->task->findOrFail($id);

        $task->update([
            'priority' => $priority,
        ]);

        return $task;
    }

    public function setDueDate(int $id, string $dueDate)
    {
        $task = $this->task->findOrFail($id);

        $task->update([
            'due_date' => $dueDate,
        ]);

        return $task;
    }

    public function updateStatus(int $id, string $status)
    {
        $task = $this->task->findOrFail($id);

        $task->update([
            'status' => $status,
        ]);

        return $task;
    }

    public function search(?string $keyword = null, ?string $status = null)
    {
        return $this->task
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereRaw(
                    'LOWER(title) LIKE ?',
                    ['%' . strtolower($keyword) . '%']
                );
            })
            ->when($status !== null, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->get();
    }
}