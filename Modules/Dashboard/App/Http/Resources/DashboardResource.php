<?php

namespace Modules\Dashboard\App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Task\App\Http\Resources\TaskResource;

class DashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'projects' => [
                'total'  => (int) ($this->resource['project_statistics']['total'] ?? 0),
                'active' => (int) (($this->resource['project_statistics']['in_progress'] ?? 0)
                                 + ($this->resource['project_statistics']['planning'] ?? 0)),
            ],
            'tasks' => [
                'total'     => (int) ($this->resource['task_statistics']['total'] ?? 0),
                'completed' => (int) ($this->resource['completed_vs_pending']['completed'] ?? 0),
                'pending'   => (int) ($this->resource['completed_vs_pending']['pending'] ?? 0),
            ],
            'overdue_tasks' => TaskResource::collection($this->resource['overdue_tasks'] ?? []),
            'total_user' => (int) ($this->resource['total_user'] ?? 0),
            'recent_projects' => $this->resource['recent_projects'] ?? [],
            'upcoming_tasks' => TaskResource::collection($this->resource['upcoming_tasks'] ?? []),
            'recent_activity' => $this->resource['recent_activity'] ?? [],
        ];
    }
}