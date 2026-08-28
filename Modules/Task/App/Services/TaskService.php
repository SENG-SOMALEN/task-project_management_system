<?php

namespace Modules\Task\App\Services;

use InvalidArgumentException;
use Modules\Collaboration\App\Services\NotificationService;
use Modules\Task\App\Interfaces\TaskRepositoryInterface;
use Modules\TeamMember\App\Interfaces\TeamMemberRepositoryInterface;

class TaskService
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
        private TeamMemberRepositoryInterface $teamMemberRepository,
        private NotificationService $notificationService
    ) {}

    public function getAllTasks()
    {
        return $this->taskRepository->all();
    }

    public function getTaskById(int $id)
    {
        return $this->taskRepository->find($id);
    }

    public function createTask(array $data)
    {
        if (
            isset($data['start_date'], $data['due_date']) &&
            $data['start_date'] > $data['due_date']
        ) {
            throw new InvalidArgumentException(
                'Start date cannot be greater than due date.'
            );
        }

        $data['status'] = $data['status'] ?? 'To Do';
        $data['priority'] = $data['priority'] ?? 'Medium';

        /*
        |--------------------------------------------------------------------------
        | Validate assigned user
        |--------------------------------------------------------------------------
        */

        if (!empty($data['assigned_to'])) {
            $this->validateUserBelongsToProjectTeam(
                $data['project_id'],
                $data['assigned_to']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Create task
        |--------------------------------------------------------------------------
        */

        $task = $this->taskRepository->create($data);

        /*
        |--------------------------------------------------------------------------
        | Notification
        |--------------------------------------------------------------------------
        */

        if (!empty($task->assigned_to)) {
            $this->notificationService->createNotification([
                'user_id' => $task->assigned_to,
                'task_id' => $task->task_id,
                'title' => 'New Task Assigned',
                'message' => "You have been assigned to task: {$task->title}",
                'is_read' => false,
            ]);
        }

        return $task;
    }

    public function updateTask(int $id, array $data)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate status
        |--------------------------------------------------------------------------
        */

        if (isset($data['status'])) {
            $allowedStatuses = [
                'To Do',
                'In Progress',
                'Review',
                'Completed',
            ];

            if (!in_array($data['status'], $allowedStatuses, true)) {
                throw new InvalidArgumentException(
                    'Invalid task status.'
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Validate priority
        |--------------------------------------------------------------------------
        */

        if (isset($data['priority'])) {
            $allowedPriorities = [
                'Low',
                'Medium',
                'High',
                'Urgent',
            ];

            if (!in_array($data['priority'], $allowedPriorities, true)) {
                throw new InvalidArgumentException(
                    'Invalid task priority.'
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Validate dates
        |--------------------------------------------------------------------------
        */

        if (
            isset($data['start_date'], $data['due_date']) &&
            $data['start_date'] > $data['due_date']
        ) {
            throw new InvalidArgumentException(
                'Start date cannot be greater than due date.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validate assigned user when changing assignment
        |--------------------------------------------------------------------------
        */

        if (isset($data['assigned_to']) && !empty($data['assigned_to'])) {

            $task = $this->taskRepository->find($id);

            if (!$task) {
                throw new InvalidArgumentException(
                    'Task not found.'
                );
            }

            $this->validateUserBelongsToProjectTeam(
                $task->project_id,
                $data['assigned_to']
            );
        }

        return $this->taskRepository->update($id, $data);
    }

    public function assignTask(int $id, int $userId)
    {
        /*
        |--------------------------------------------------------------------------
        | Get Task
        |--------------------------------------------------------------------------
        */

        $task = $this->taskRepository->find($id);

        if (!$task) {
            throw new InvalidArgumentException(
                'Task not found.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Check Team Membership
        |--------------------------------------------------------------------------
        */

        $this->validateUserBelongsToProjectTeam(
            $task->project_id,
            $userId
        );

        /*
        |--------------------------------------------------------------------------
        | Assign Task
        |--------------------------------------------------------------------------
        */

        $task = $this->taskRepository->assignTask(
            $id,
            $userId
        );

        /*
        |--------------------------------------------------------------------------
        | Notification
        |--------------------------------------------------------------------------
        */

        $this->notificationService->createNotification([
            'user_id' => $userId,
            'task_id' => $task->task_id,
            'title' => 'New Task Assigned',
            'message' => "You have been assigned to task: {$task->title}",
            'is_read' => false,
        ]);

        return $task;
    }

    public function setPriority(int $id, string $priority)
    {
        $allowedPriorities = [
            'Low',
            'Medium',
            'High',
            'Urgent',
        ];

        if (!in_array($priority, $allowedPriorities, true)) {
            throw new InvalidArgumentException(
                'Invalid task priority.'
            );
        }

        return $this->taskRepository->setPriority(
            $id,
            $priority
        );
    }

    public function setDueDate(int $id, string $dueDate)
    {
        if ($dueDate < date('Y-m-d')) {
            throw new InvalidArgumentException(
                'Due date cannot be in the past.'
            );
        }

        return $this->taskRepository->setDueDate(
            $id,
            $dueDate
        );
    }

    public function deleteTask(int $id)
    {
        return $this->taskRepository->delete($id);
    }

    public function updateStatus(int $id, string $status)
    {
        $allowedStatuses = [
            'To Do',
            'In Progress',
            'Review',
            'Completed',
        ];

        if (!in_array($status, $allowedStatuses, true)) {
            throw new InvalidArgumentException(
                'Invalid task status.'
            );
        }

        $task = $this->taskRepository->find($id);

        if (!$task) {
            throw new InvalidArgumentException(
                'Task not found.'
            );
        }

        if ($task->status === $status) {
            return $task;
        }

        $task = $this->taskRepository->updateStatus(
            $id,
            $status
        );

        $message = "Task \"{$task->title}\" status has been changed to {$status}.";

        if ($status === 'Completed') {
            $message = "Task \"{$task->title}\" has been completed.";
        }

        if (!empty($task->assigned_to)) {
            $this->notificationService->createNotification([
                'user_id' => $task->assigned_to,
                'task_id' => $task->task_id,
                'title' => 'Task Status Updated',
                'message' => $message,
                'is_read' => false,
            ]);
        }

        return $task;
    }

    public function searchTask(
        ?string $keyword = null,
        ?string $status = null
    ) {
        return $this->taskRepository->search(
            $keyword,
            $status
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Validate User Belongs To Project Team
    |--------------------------------------------------------------------------
    */

    private function validateUserBelongsToProjectTeam(
        int $projectId,
        int $userId
    ): void {
        $task = $this->taskRepository->getProjectTeamId(
            $projectId
        );

        if (!$task) {
            throw new InvalidArgumentException(
                'Project not found.'
            );
        }

        $teamId = $task->team_id;

        $isMember = $this->teamMemberRepository->exists(
            $teamId,
            $userId
        );

        if (!$isMember) {
            throw new InvalidArgumentException(
                'The selected user is not a member of this project team.'
            );
        }
    }
}