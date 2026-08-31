<?php

namespace Modules\Team\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'team_id' => $this->team_id,
            'team_name' => $this->team_name,
            'description' => $this->description,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'members' => $this->whenLoaded('members', function () {
                return $this->members->map(function ($member) {
                    return [
                        'team_member_id' => $member->team_member_id,
                        'user_id' => $member->user_id,
                        'username' => $member->user?->username,
                        'email' => $member->user?->email,
                        'role' => $member->user?->role,
                        'joined_at' => $member->joined_at,
                        'tasks' => $member->user
                            ?->assignedTasks
                            ?->whereIn(
                                'project_id',
                                $this->projects->pluck('project_id')
                            )
                            ->values()
                            ->map(function ($task) {
                                return [
                                    'task_id' => $task->task_id,
                                    'project_id' => $task->project_id,
                                    'title' => $task->title,
                                    'priority' => $task->priority,
                                    'status' => $task->status,
                                    'start_date' => $task->start_date,
                                    'due_date' => $task->due_date,
                                ];
                            }),
                    ];
                });
            }),

            'projects' => $this->whenLoaded('projects', function () {
                return $this->projects->map(function ($project) {
                    return [
                        'project_id' => $project->project_id,
                        'project_name' => $project->project_name,
                        'description' => $project->description,
                        'start_date' => $project->start_date,
                        'due_date' => $project->due_date,
                        'status' => $project->status,

                        'tasks' => $project->tasks->map(function ($task) {
                            return [
                                'task_id' => $task->task_id,
                                'assigned_to' => $task->assigned_to,
                                'assigned_user' => $task->assignedUser?->username,
                                'title' => $task->title,
                                'priority' => $task->priority,
                                'status' => $task->status,
                                'start_date' => $task->start_date,
                                'due_date' => $task->due_date,
                            ];
                        }),
                    ];
                });
            }),
        ];
    }
}