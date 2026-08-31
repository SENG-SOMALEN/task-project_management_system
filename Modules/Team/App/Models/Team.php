<?php

namespace Modules\Team\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ProjectManagement\App\Models\Project;
use Modules\TeamMember\App\Models\TeamMember;
use Modules\User\App\Models\User;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'teams';
    protected $primaryKey = 'team_id';
    protected $fillable = [
        'team_name',
        'description',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by',
            'user_id'
        );
    }

    public function members()
    {
        return $this->hasMany(
            TeamMember::class,
            'team_id',
            'team_id'
        );
    }

    public function projects()
    {
        return $this->hasMany(
            Project::class,
            'team_id',
            'team_id'
        );
    }
}
