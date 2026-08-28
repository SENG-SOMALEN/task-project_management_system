<?php

namespace Modules\TeamMember\App\Services;

use Modules\TeamMember\App\Interfaces\TeamMemberRepositoryInterface;

class TeamMemberService
{
    public function __construct(
        private TeamMemberRepositoryInterface $teamMemberRepository
    ) {}

    public function getAllTeamMembers()
    {
        return $this->teamMemberRepository->all();
    }

    public function getTeamMemberById(int $id)
    {
        return $this->teamMemberRepository->find($id);
    }

    public function getTeamMembersByTeamId(int $teamId)
    {
        return $this->teamMemberRepository->getByTeamId($teamId);
    }

    public function addMember(int $teamId, int $userId)
    {
        if ($this->teamMemberRepository->exists($teamId, $userId)) {
            throw new \Exception(
                'User is already a member of this team.'
            );
        }

        return $this->teamMemberRepository->create([
            'team_id' => $teamId,
            'user_id' => $userId,
            'joined_at' => now(),
        ]);
    }

    public function updateTeamMember(int $id, array $data)
    {
        return $this->teamMemberRepository->update($id, $data);
    }

    public function removeMember(int $id)
    {
        return $this->teamMemberRepository->delete($id);
    }
}