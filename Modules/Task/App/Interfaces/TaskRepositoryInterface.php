<?php

namespace Modules\Task\App\Interfaces;

interface TaskRepositoryInterface
{
    public function all();
    public function create(array $data);

    public function find(int $id);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function assignTask(int $id, int $userId);

    public function setPriority(int $id, string $priority);

    public function setDueDate(int $id, string $dueDate);

    public function updateStatus(int $id, string $status);

    public function search(string $keyword, string $status);
}