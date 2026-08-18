<?php

namespace Modules\Task\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:projects,project_id',
            ],

            'assigned_to' => [
                'sometimes',
                'required',
                'integer',
                'exists:users,user_id',
            ],

            'title' => [
                'sometimes',
                'required',
                'string',
                'max:150',
            ],

            'description' => [
                'sometimes',
                'nullable',
                'string',
            ],

            'priority' => [
                'sometimes',
                'required',
                'in:Low,Medium,High,Urgent',
            ],

            'status' => [
                'sometimes',
                'required',
                'in:To Do,In Progress,Review,Completed',
            ],

            'start_date' => [
                'sometimes',
                'nullable',
                'date',
            ],

            'due_date' => [
                'sometimes',
                'required',
                'date',
                'after_or_equal:start_date',
            ],

            'created_by' => [
                'sometimes',
                'required',
                'integer',
                'exists:users,user_id',
            ],
        ];
    }
}