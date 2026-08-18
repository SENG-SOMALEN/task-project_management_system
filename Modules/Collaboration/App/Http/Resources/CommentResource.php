<?php

namespace Modules\Collaboration\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'task_comment_id' => $this->task_comment_id,
            'task_id' => $this->task_id,
            'user_id' => $this->user_id,
            'comment' => $this->comment,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
