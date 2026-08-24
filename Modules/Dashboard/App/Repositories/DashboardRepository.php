<?php

namespace Modules\Dashboard\App\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Dashboard\App\Interfaces\DashboardRepositoryInterface;

class DashboardRepository implements DashboardRepositoryInterface
{
    /**
     * Project statistics
     */
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
            'total' => (int) ($stats->total ?? 0),
            'planning' => (int) ($stats->planning ?? 0),
            'in_progress' => (int) ($stats->in_progress ?? 0),
            'completed' => (int) ($stats->completed ?? 0),
        ];
    }

    /**
     * Task statistics
     */
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
            'total' => (int) ($stats->total ?? 0),
            'to_do' => (int) ($stats->to_do ?? 0),
            'in_progress' => (int) ($stats->in_progress ?? 0),
            'review' => (int) ($stats->review ?? 0),
            'completed' => (int) ($stats->completed ?? 0),
        ];
    }

    /**
     * Completed vs Pending tasks
     */
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
            'pending' => (int) ($stats->pending ?? 0),
        ];
    }

    /**
     * Overdue tasks
     */
    public function getOverdueTasks(): array
    {
        return DB::table('tasks')
            ->where('status', '!=', 'Completed')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', now()->toDateString())
            ->get()
            ->map(fn ($task) => (array) $task)
            ->toArray();
    }

    /**
     * Recent projects
     */
    public function getRecentProjects(): array
    {
        return DB::table('projects')
            ->select([
                'project_id',
                'project_name',
                'description',
                'start_date',
                'due_date',
                'status',
                'created_by',
                'created_at',
                'updated_at',
            ])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(fn ($project) => (array) $project)
            ->toArray();
    }

    /**
     * Upcoming tasks
     */
    public function getUpcomingTasks(): array
    {
        return DB::table('tasks')
            ->where('status', '!=', 'Completed')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '>=', now()->toDateString())
            ->select([
                'task_id',
                'project_id',
                'assigned_to',
                'title',
                'description',
                'priority',
                'status',
                'start_date',
                'due_date',
                'create_by',
                'created_at',
                'updated_at',
            ])
            ->orderBy('due_date', 'asc')
            ->limit(10)
            ->get()
            ->map(fn ($task) => (array) $task)
            ->toArray();
    }

    /**
     * Recent activity
     */
    public function getRecentActivity(): array
    {
        return DB::table('tasks')
            ->leftJoin(
                'projects',
                'tasks.project_id',
                '=',
                'projects.project_id'
            )
            ->leftJoin(
                'users',
                'tasks.create_by',
                '=',
                'users.user_id'
            )
            ->leftJoin(
                'users as assigned_users',
                'tasks.assigned_to',
                '=',
                'assigned_users.user_id'
            )
            ->select([
                'tasks.task_id',
                'tasks.title as task_name',
                'tasks.status',
                'tasks.priority',
                'tasks.due_date',
                'tasks.created_at',

                'projects.project_name',

                'users.username as created_by_username',

                'assigned_users.username as assigned_to_username',
            ])
            ->orderBy('tasks.created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(fn ($activity) => (array) $activity)
            ->toArray();
    }

    /**
     * Total users
     */
    public function getTotalUsers(): int
    {
        return (int) DB::table('users')->count();
    }
}