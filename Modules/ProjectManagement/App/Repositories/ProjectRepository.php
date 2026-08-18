<?php

namespace Modules\ProjectManagement\App\Repositories;

use Modules\ProjectManagement\App\Interfaces\ProjectRepositoryInterface;
use Modules\ProjectManagement\App\Models\Project;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function __construct(private Project $project) {}

    public function all()
    {
        return $this->project->all();
    }
    public function find(int $id)
    {
        return $this->project->find($id);
    }
    public function create(array $data)
    {
        return $this->project->create($data);
    }
    public function update(int $id, array $data)
    {
        $project = $this->project->findOrFail($id);

        $project->update($data);

        return $project;
    }
    public function delete(int $id)
    {
        $project = $this->project->findOrFail($id);

        return $project->delete();
    }
    public function searchAndFilter(?string $keyword, ?string $status)
    {
        return $this->project
                        ->when($keyword, function($query) use ($keyword) {
                                $query->where('project_name', 'like', "%{$keyword}%");
                        })
                        ->when(!is_null($status), function($query) use ($status) {
                                $query->where('status', $status);
                        })->get();
    }
}