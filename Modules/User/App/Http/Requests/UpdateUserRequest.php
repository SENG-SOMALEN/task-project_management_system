<?php

namespace Modules\User\App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;


class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'username' => [
                'sometimes',
                'required',
                'string',
                'max:50',
            ],

            'gender' => [
                'sometimes',
                'required',
                Rule::in(['Male', 'Female']),
            ],

            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users', 'email')
                    ->ignore($userId, 'user_id'),
            ],

            'password' => [
                'sometimes',
                'required',
                'string',
                'min:6',
                'max:255',
            ],

            'role' => [
                'sometimes',
                'required',
                Rule::in([
                    'Admin',
                    'ProjectManager',
                    'TeamMember',
                ]),
            ],
            'status' => [
                'sometimes',
                'boolean',
                Rule::in(['Active', 'Inactive']),
            ],
        ];
    }
}
