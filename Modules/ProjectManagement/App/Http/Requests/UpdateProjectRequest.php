<?php

namespace Modules\ProjectManagement\App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'project_name' => [
                'sometimes',
                'required',
                'string',
                'max:60',
            ],

            'description' => [
                'sometimes',
                'nullable',
                'string',
            ],

            'start_date' => [
                'sometimes',
                'required',
                'date',
            ],

            'due_date' => [
                'sometimes',
                'required',
                'date',
                'after_or_equal:start_date'
            ],

            'status' => [
                'sometimes',
                'required',
                Rule::in([
                    'Planning',
                    'In Progress',
                    'Completed',
                ]),
            ],
        ];
    }
}
