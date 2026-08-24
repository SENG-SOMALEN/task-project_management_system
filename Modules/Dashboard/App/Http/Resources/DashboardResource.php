<?php

namespace Modules\Dashboard\App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'projects' => [
                'total' => (int) (
                    $this->resource['project_statistics']['total'] ?? 0
                ),

                'active' => (int) (
                    ($this->resource['project_statistics']['in_progress'] ?? 0)
                    +
                    ($this->resource['project_statistics']['planning'] ?? 0)
                ),

                'planning' => (int) (
                    $this->resource['project_statistics']['planning'] ?? 0
                ),

                'in_progress' => (int) (
                    $this->resource['project_statistics']['in_progress'] ?? 0
                ),

                'completed' => (int) (
                    $this->resource['project_statistics']['completed'] ?? 0
                ),
            ],

            'tasks' => [
                'total' => (int) (
                    $this->resource['task_statistics']['total'] ?? 0
                ),

                'to_do' => (int) (
                    $this->resource['task_statistics']['to_do'] ?? 0
                ),

                'in_progress' => (int) (
                    $this->resource['task_statistics']['in_progress'] ?? 0
                ),

                'review' => (int) (
                    $this->resource['task_statistics']['review'] ?? 0
                ),

                'completed' => (int) (
                    $this->resource['task_statistics']['completed'] ?? 0
                ),

                'pending' => (int) (
                    $this->resource['completed_vs_pending']['pending'] ?? 0
                ),
            ],

            'completed_vs_pending' => [
                'completed' => (int) (
                    $this->resource['completed_vs_pending']['completed'] ?? 0
                ),

                'pending' => (int) (
                    $this->resource['completed_vs_pending']['pending'] ?? 0
                ),
            ],

            'overdue_tasks' => $this->resource['overdue_tasks'] ?? [],

            'recent_projects' => $this->resource['recent_projects'] ?? [],

            'upcoming_tasks' => $this->resource['upcoming_tasks'] ?? [],

            'recent_activity' => $this->resource['recent_activity'] ?? [],

            'total_user' => (int) (
                $this->resource['total_user'] ?? 0
            ),
        ];
    }
}