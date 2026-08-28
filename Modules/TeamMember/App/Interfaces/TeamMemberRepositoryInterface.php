<?php

namespace Modules\TeamMember\App\Interfaces;

interface TeamMemberRepositoryInterface
{
    public function all();

    public function find(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function getByTeamId(int $teamId);

    public function exists(int $teamId, int $userId);
}