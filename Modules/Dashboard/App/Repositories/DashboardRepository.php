<?php

namespace Modules\Dashboard\App\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Dashboard\App\Interfaces\DashboardRepositoryInterface;
use Modules\Task\App\Models\Task;
use Modules\User\App\Models\User;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function getProjectStatistics(): array
    {
        $stats = DB::table('projects')
            ->selectRaw("
                COUNT(*) as total,
                COUNT(CASE WHEN status = 'Planning' THEN 1 END) as planning,
                COUNT(CASE WHEN status = 'In Progress' THEN 1 END) as in_progress,
                COUNT(CASE WHEN status = 'Completed' THEN 1 END) as completed
            ")
            ->first();

        return [
            'total'       => (int) ($stats->total ?? 0),
            'planning'    => (int) ($stats->planning ?? 0),
            'in_progress' => (int) ($stats->in_progress ?? 0),
            'completed'   => (int) ($stats->completed ?? 0),
        ];
    }

    public function getTaskStatistics(): array
    {
        $stats = DB::table('tasks')
            ->selectRaw("
                COUNT(*) as total,
                COUNT(CASE WHEN status = 'To Do' THEN 1 END) as to_do,
                COUNT(CASE WHEN status = 'In Progress' THEN 1 END) as in_progress,
                COUNT(CASE WHEN status = 'Review' THEN 1 END) as review,
                COUNT(CASE WHEN status = 'Completed' THEN 1 END) as completed
            ")
            ->first();

        return [
            'total'       => (int) ($stats->total ?? 0),
            'to_do'       => (int) ($stats->to_do ?? 0),
            'in_progress' => (int) ($stats->in_progress ?? 0),
            'review'      => (int) ($stats->review ?? 0),
            'completed'   => (int) ($stats->completed ?? 0),
        ];
    }

    public function getCompletedVsPendingTasks(): array
    {
        $stats = DB::table('tasks')
            ->selectRaw("
                COUNT(CASE WHEN status = 'Completed' THEN 1 END) as completed,
                COUNT(CASE WHEN status != 'Completed' THEN 1 END) as pending
            ")
            ->first();

        return [
            'completed' => (int) ($stats->completed ?? 0),
            'pending'   => (int) ($stats->pending ?? 0),
        ];
    }

    public function getOverdueTasks()
    {
        return Task::query()
            ->where('status', '!=', 'Completed')
            ->where('due_date', '<', now())
            ->get();
    }

    public function getRecentProjects(): array
    {
        return DB::table('projects')
            ->select([
                'project_id',
                'name',
                'status',
                'created_at',
            ])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->toArray();
    }

    public function getUpcomingTasks(): array
    {
        return Task::query()
            ->with([
                'project:project_id,name',
                'assignedUser:user_id,username',
            ])
            ->where('status', '!=', 'Completed')
            ->whereDate('due_date', '>=', now()->toDateString())
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get()
            ->toArray();
    }

    public function getRecentActivity(): array
    {
        return Task::query()
            ->with([
                'creator:user_id,username',
                'project:project_id,name',
                'assignedUser:user_id,username',
            ])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($task) {
                return [
                    'type' => 'task',
                    'action' => 'created',
                    'task_id' => $task->task_id,
                    'task_name' => $task->title,
                    'project' => $task->project?->name,
                    'created_by' => $task->creator?->username,
                    'assigned_to' => $task->assignedUser?->username,
                    'created_at' => $task->created_at,
                ];
            })
            ->toArray();
    }

    public function getTotalUsers(): int
    {
        return User::query()->count();
    }
}