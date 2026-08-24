<?php

namespace Modules\Dashboard\App\Interfaces;

interface DashboardRepositoryInterface
{
    public function getProjectStatistics(): array;

    public function getTaskStatistics(): array;

    public function getCompletedVsPendingTasks(): array;

    public function getOverdueTasks(): array;

    public function getRecentProjects(): array;

    public function getUpcomingTasks(): array;

    public function getRecentActivity(): array;

    public function getTotalUsers(): int;
}