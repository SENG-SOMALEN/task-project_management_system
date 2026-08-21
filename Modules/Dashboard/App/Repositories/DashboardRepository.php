<?php

namespace Modules\Dashboard\App\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Dashboard\App\Interfaces\DashboardRepositoryInterface;

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

    public function getOverdueTasks(): array
    {
        return DB::table('tasks')
            ->where('status', '!=', 'Completed')
            ->where('due_date', '<', now())
            ->orderBy('due_date', 'asc')
            ->get()
            ->toArray();
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
        return DB::table('tasks')
            ->select([
                'task_id',
                'title',
                'status',
                'due_date',
                'project_id',
                'assigned_to',
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
        return DB::table('tasks')
            ->leftJoin(
                'projects',
                'tasks.project_id',
                '=',
                'projects.project_id'
            )
            ->leftJoin(
                'users as creators',
                'tasks.created_by',
                '=',
                'creators.user_id'
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
                'tasks.created_at',
                'projects.name as project_name',
                'creators.username as created_by',
                'assigned_users.username as assigned_to',
            ])
            ->orderBy('tasks.created_at', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function getTotalUsers(): int
    {
        $stats = DB::table('users')
            ->selectRaw('COUNT(*) as total')
            ->first();

        return (int) ($stats->total ?? 0);
    }
}