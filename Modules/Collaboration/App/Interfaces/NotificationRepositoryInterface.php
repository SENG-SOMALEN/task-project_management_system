<?php

namespace Modules\Collaboration\App\Interfaces;

interface NotificationRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function markAsRead(int $id);
    public function markAsUnread(int $id);
    public function delete(int $id);
}