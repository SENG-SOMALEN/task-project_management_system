<?php

namespace Modules\Dashboard\App\Services;

use Modules\Dashboard\App\Interfaces\DashboardRepositoryInterface;

class DashboardService
{
    public function __construct(private DashboardRepositoryInterface $dashboardRepository){}

    public function getProjectStatistics()
    {
        return $this->dashboardRepository->getProjectStatistics();
    }

    public function getTaskStatistics()
    {
        return $this->dashboardRepository->getTaskStatistics();
    }

    public function getCompletedVsPendingTasks()
    {
        return $this->dashboardRepository->getCompletedVsPendingTasks();
    }

    public function getOverdueTasks()
    {
        return $this->dashboardRepository->getOverdueTasks();
    }

    public function getRecentProjects()
    {
        return $this->dashboardRepository->getRecentProjects();
    }

    public function getUpcomingTasks()
    {
        return $this->dashboardRepository->getUpcomingTasks();
    }

    public function getRecentActivity()
    {
        return $this->dashboardRepository->getRecentActivity();
    }

    public function getTotalUsers()
    {
        return $this->dashboardRepository->getTotalUsers();
    }
}