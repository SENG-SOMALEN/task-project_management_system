<?php

namespace Modules\Team\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $teamId = $this->route('team');

        return [
            'team_name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('teams', 'team_name')->ignore($teamId, 'team_id'),
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