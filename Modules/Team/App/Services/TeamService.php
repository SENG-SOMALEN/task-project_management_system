<?php

namespace Modules\Team\App\Services;

use Modules\Team\App\Interfaces\TeamRepositoryInterface;

class TeamService
{
    public function __construct(
        private TeamRepositoryInterface $teamRepository
    ) {}

    public function getAllTeams()
    {
        return $this->teamRepository->all();
    }

    public function getTeamById(int $id)
    {
        return $this->teamRepository->find($id);
    }

    public function createTeam(array $data)
    {
        return $this->teamRepository->create($data);
    }

    public function updateTeam(int $id, array $data)
    {
        return $this->teamRepository->update($id, $data);
    }

    public function deleteTeam(int $id)
    {
        return $this->teamRepository->delete($id);
    }
}