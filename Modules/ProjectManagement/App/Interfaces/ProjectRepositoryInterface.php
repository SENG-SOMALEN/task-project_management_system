<?php

namespace Modules\ProjectManagement\App\Interfaces;

interface ProjectRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function searchAndFilter(?string $keyword, ?string $status);
}