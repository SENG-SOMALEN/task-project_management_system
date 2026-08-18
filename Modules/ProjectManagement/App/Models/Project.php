<?php

namespace Modules\ProjectManagement\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\App\Models\User;

class Project extends Model
{
    protected $primaryKey = 'project_id';

    protected $fillable = [
        'project_name',
        'description',
        'start_date',
        'due_date',
        'status',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
}