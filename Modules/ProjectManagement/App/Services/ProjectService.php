<?php

namespace Modules\ProjectManagement\App\Services;

use Modules\ProjectManagement\App\Interfaces\ProjectRepositoryInterface;

class ProjectService
{
    public function __construct(private ProjectRepositoryInterface $projectRepositoryInterface) {}

    public function getAllProject()
    {
        return $this->projectRepositoryInterface->all();
    }
    public function getProjectById(int $id)
    {
        return $this->projectRepositoryInterface->find($id);
    }
    public function createProject(array $data)
    {
        return $this->projectRepositoryInterface->create($data);
    }
    public function updateProject(int $id, array $data)
    {
        return $this->projectRepositoryInterface->update($id, $data);
    }
    public function deleteProject(int $id)
    {
        return $this->projectRepositoryInterface->delete($id);
    }
    public function searchFilterProject(?string $keyword, ?string $status)
    {
        return $this->projectRepositoryInterface->searchAndFilter($keyword, $status);
    }
}