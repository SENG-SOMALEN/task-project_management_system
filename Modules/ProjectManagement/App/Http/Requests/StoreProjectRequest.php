<?php

namespace Modules\ProjectManagement\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'project_name' => 'required|string|max:60',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Planning,In Progress,Completed',
            'created_by' => 'required|exists:users,user_id'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
