<?php

namespace Modules\Collaboration\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Collaboration\App\Http\Requests\StoreNotificationRequest;
use Modules\Collaboration\App\Services\NotificationService;
use Modules\Collaboration\App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    /**
     * Display a listing of notifications.
     */
    public function index()
    {
        $notifications = $this->notificationService
            ->getAllNotifications();

        return NotificationResource::collection($notifications);
    }

    /**
     * Display the specified notification.
     */
    public function show(int $id)
    {
        $notification = $this->notificationService
            ->getNotificationById($id);

        return new NotificationResource($notification);
    }

    public function store(StoreNotificationRequest $request)
    {
        $notification = $this->notificationService->createNotification(
            $request->validated()
        );

        return new NotificationResource($notification);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(int $id)
    {
        $notification = $this->notificationService
            ->markAsRead($id);

        return new NotificationResource($notification);
    }

    /**
     * Mark notification as unread.
     */
    public function markAsUnread(int $id)
    {
        $notification = $this->notificationService
            ->markAsUnread($id);

        return new NotificationResource($notification);
    }

    /**
     * Remove the specified notification.
     */
    public function destroy(int $id)
    {
        $this->notificationService->deleteNotification($id);

        return response()->json([
            'status' => true,
            'message' => 'Notification deleted successfully.',
        ]);
    }
}