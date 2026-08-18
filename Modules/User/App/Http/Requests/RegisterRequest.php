<?php

namespace Modules\User\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'max:50',
            ],

            'gender' => [
                'required',
                'in:Male,Female',
            ],

            'email' => [
                'required',
                'email',
                'max:100',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'max:255',
                'confirmed',
            ],
        ];
    }
}