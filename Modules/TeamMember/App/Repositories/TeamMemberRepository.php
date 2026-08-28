<?php

namespace Modules\TeamMember\App\Repositories;

use Modules\TeamMember\App\Interfaces\TeamMemberRepositoryInterface;
use Modules\TeamMember\App\Models\TeamMember;
class TeamMemberRepository implements TeamMemberRepositoryInterface
{
    public function __construct(
        private TeamMember $teamMember
    ) {}

    public function all()
    {
        return $this->teamMember
            ->with(['team', 'user'])
            ->get();
    }

    public function find(int $id)
    {
        return $this->teamMember
            ->with(['team', 'user'])
            ->find($id);
    }

    public function create(array $data)
    {
        return $this->teamMember->create($data);
    }

    public function update(int $id, array $data)
    {
        $teamMember = $this->teamMember->findOrFail($id);

        $teamMember->update($data);

        return $teamMember;
    }

    public function delete(int $id)
    {
        $teamMember = $this->teamMember->findOrFail($id);

        return $teamMember->delete();
    }

    public function getByTeamId(int $teamId)
    {
        return $this->teamMember
            ->with('user')
            ->where('team_id', $teamId)
            ->get();
    }

    public function exists(int $teamId, int $userId)
    {
        return $this->teamMember
            ->where('team_id', $teamId)
            ->where('user_id', $userId)
            ->exists();
    }
}