<?php

namespace Modules\User\App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Task\App\Models\Task;
use Modules\Team\App\Models\Team;
use Modules\TeamMember\App\Models\TeamMember;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'username',
        'gender',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function teamMemberships()
    {
        return $this->hasMany(
            TeamMember::class,
            'user_id',
            'user_id'
        );
    }

    public function teams()
    {
        return $this->belongsToMany(
            Team::class,
            'team_members',
            'user_id',
            'team_id',
            'user_id',
            'team_id'
        );
    }

    public function assignedTasks()
    {
        return $this->hasMany(
            Task::class,
            'assigned_to',
            'user_id'
        );
    }
}