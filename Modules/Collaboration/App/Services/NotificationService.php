<?php

namespace Modules\Collaboration\App\Services;

use Modules\Collaboration\App\Interfaces\NotificationRepositoryInterface;

class NotificationService
{
    public function __construct(private NotificationRepositoryInterface $notificationRepository){}

    public function getAllNotifications()
    {
        return $this->notificationRepository->all();
    }

    public function getNotificationById(int $id)
    {
        return $this->notificationRepository->find($id);
    }

    public function createNotification(array $data)
    {
        return $this->notificationRepository->create($data);
    }

    public function markAsRead(int $id)
    {
        return $this->notificationRepository->markAsRead($id);
    }

    public function markAsUnread(int $id)
    {
        return $this->notificationRepository->markAsUnread($id);
    }

    public function deleteNotification(int $id)
    {
        return $this->notificationRepository->delete($id);
    }
}