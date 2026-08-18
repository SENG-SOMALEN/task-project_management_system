<?php

namespace Modules\Dashboard\App\Interfaces;

interface DashboardRepositoryInterface
{
    public function getProjectStatistics();

    public function getTaskStatistics();

    public function getCompletedVsPendingTasks();

    public function getOverdueTasks();
}