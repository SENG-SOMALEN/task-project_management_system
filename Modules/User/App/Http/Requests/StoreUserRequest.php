<?php

namespace Modules\User\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'username' => 'required|string|max:50',
            'gender' => 'required|in:Male,Female',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|max:255',
            'role' => 'required|in:Admin,ProjectManager,TeamMember',
            'status' => 'required|boolean'
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
