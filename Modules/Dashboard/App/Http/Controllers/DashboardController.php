<?php

namespace Modules\Dashboard\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Dashboard\App\Http\Resources\DashboardResource;
use Modules\Dashboard\App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboardService){}

    public function index()
    {
        $data = [
            'project_statistics'   => $this->dashboardService->getProjectStatistics(),
            'task_statistics'      => $this->dashboardService->getTaskStatistics(),
            'completed_vs_pending' => $this->dashboardService->getCompletedVsPendingTasks(),
            'overdue_tasks'        => $this->dashboardService->getOverdueTasks(),
        ];

        return new DashboardResource($data);
    }
}