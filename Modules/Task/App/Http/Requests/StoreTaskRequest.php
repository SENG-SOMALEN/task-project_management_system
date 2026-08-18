<?php

namespace Modules\Task\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => [
                'required',
                'integer',
                'exists:projects,project_id',
            ],

            'assigned_to' => [
                'required',
                'integer',
                'exists:users,user_id',
            ],

            'title' => [
                'required',
                'string',
                'max:150',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'priority' => [
                'sometimes',
                'in:Low,Medium,High,Urgent',
            ],

            'status' => [
                'sometimes',
                'in:To Do,In Progress,Review,Completed',
            ],

            'start_date' => [
                'nullable',
                'date',
            ],

            'due_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],

            'created_by' => [
                'required',
                'integer',
                'exists:users,user_id',
            ],
        ];
    }
}