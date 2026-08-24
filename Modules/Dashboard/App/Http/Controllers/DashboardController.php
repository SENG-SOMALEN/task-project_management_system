<?php

namespace Modules\Dashboard\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Dashboard\App\Http\Resources\DashboardResource;
use Modules\Dashboard\App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    ) {}

    public function index()
    {
        return response()->json([
            'projects' => $this->dashboardService->getProjectStatistics(),
        ]);
    }
}