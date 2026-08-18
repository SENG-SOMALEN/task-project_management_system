<?php

namespace Modules\Collaboration\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarkNotificationReadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_read' => [
                'required',
                'boolean',
            ],
        ];
    }
}