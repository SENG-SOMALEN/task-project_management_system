<?php

namespace Modules\Team\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'team_name' => [
                'required',
                'string',
                'max:100',
                'unique:teams,team_name',
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'team_name.required' => 'Team name is required.',
            'team_name.unique' => 'Team name already exists.',
            'team_name.max' => 'Team name may not be greater than 100 characters.',
        ];
    }
}