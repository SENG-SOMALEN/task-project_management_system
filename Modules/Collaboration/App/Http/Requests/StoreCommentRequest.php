<?php

namespace Modules\Collaboration\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'task_id' => [
                'required',
                'integer',
                'exists:tasks,task_id',
            ],
            'user_id' => [
                'required',
                'integer',
                'exists:users,user_id',
            ],
            'comment' => [
                'required',
                'string',
            ],
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
