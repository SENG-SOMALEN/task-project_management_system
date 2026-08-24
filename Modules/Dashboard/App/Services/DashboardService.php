<?php

namespace Modules\Dashboard\App\Services;

use Modules\Dashboard\App\Interfaces\DashboardRepositoryInterface;

class DashboardService
{
    public function __construct(
        private DashboardRepositoryInterface $dashboardRepository
    ) {}

    public function getProjectStatistics(): array
    {
        return $this->dashboardRepository->getProjectStatistics();
    }

    public function getTaskStatistics(): array
    {
        return $this->dashboardRepository->getTaskStatistics();
    }

    public function getCompletedVsPendingTasks(): array
    {
        return $this->dashboardRepository->getCompletedVsPendingTasks();
    }

    public function getOverdueTasks(): array
    {
        return $this->dashboardRepository->getOverdueTasks();
    }

    public function getRecentProjects(): array
    {
        return $this->dashboardRepository->getRecentProjects();
    }

    public function getUpcomingTasks(): array
    {
        return $this->dashboardRepository->getUpcomingTasks();
    }

    public function getRecentActivity(): array
    {
        return $this->dashboardRepository->getRecentActivity();
    }

    public function getTotalUsers(): int
    {
        return $this->dashboardRepository->getTotalUsers();
    }
}