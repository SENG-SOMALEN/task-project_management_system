<?php

namespace Modules\Team\App\Repositories;

use Modules\Team\App\Interfaces\TeamRepositoryInterface;
use Modules\Team\App\Models\Team;

class TeamRepository implements TeamRepositoryInterface
{
    public function __construct(
        private Team $team
    ) {}

    public function all()
    {
        return $this->team->all();
    }

    public function find(int $id)
    {
        return $this->team->find($id);
    }

    public function create(array $data)
    {
        return $this->team->create($data);
    }

    public function update(int $id, array $data)
    {
        $team = $this->team->findOrFail($id);

        $team->update($data);

        return $team;
    }

    public function delete(int $id)
    {
        $team = $this->team->findOrFail($id);

        return $team->delete();
    }
}