<?php

namespace Modules\Collaboration\App\Repositories;

use Modules\Collaboration\App\Interfaces\NotificationRepositoryInterface;
use Modules\Collaboration\App\Models\Notification;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function __construct(private Notification $notification){}

    public function all()
    {
        return $this->notification->all();
    }

    public function find(int $id)
    {
        return $this->notification->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->notification->create($data);
    }

    public function markAsRead(int $id)
    {
        $notification = $this->notification->findOrFail($id);

        $notification->update([
            'is_read' => true
        ]);

        return $notification;
    }

    public function markAsUnread(int $id)
    {
        $notification = $this->notification->findOrFail($id);

        $notification->update([
            'is_read' => false
        ]);

        return $notification;
    }

    public function delete(int $id)
    {
        $notification = $this->notification->findOrFail($id);

        return $notification->delete();
    }
}