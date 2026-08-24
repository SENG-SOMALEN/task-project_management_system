<?php

namespace Modules\Collaboration\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'integer',
                'exists:users,user_id',
            ],
            'task_id' => [
                'nullable',
                'integer',
                'exists:tasks,task_id',
            ],
            'title' => [
                'required',
                'string',
                'max:150',
            ],
            'message' => [
                'required',
                'string',
            ],
            'is_read' => [
                'sometimes',
                'boolean',
            ],
        ];
    }
}