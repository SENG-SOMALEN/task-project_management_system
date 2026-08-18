<?php

namespace Modules\Dashboard\App\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Dashboard\App\Interfaces\DashboardRepositoryInterface;
use Modules\Task\App\Models\Task;

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
}