<?php

namespace Modules\User\App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'user_id' => $this->resource['user']->user_id,
                'username' => $this->resource['user']->username,
                'gender' => $this->resource['user']->gender,
                'email' => $this->resource['user']->email,
                'role' => $this->resource['user']->role,
                'status' => $this->resource['user']->status,
            ],

            'token' => $this->resource['token'] ?? null,
            'token_type' => 'Bearer',
        ];
    }
}