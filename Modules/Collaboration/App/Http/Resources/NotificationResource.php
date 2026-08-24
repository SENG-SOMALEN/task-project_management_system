<?php

namespace Modules\Collaboration\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'notification_id' => $this->notification_id,
            'user_id' => $this->user_id,
            'task_id' => $this->task_id,
            'title' => $this->title,
            'message' => $this->message,
            'is_read' => $this->is_read,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s')
        ];
    }
}
