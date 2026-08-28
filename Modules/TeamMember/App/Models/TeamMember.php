<?php

namespace Modules\TeamMember\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Team\App\Models\Team;
use Modules\User\App\Models\User;

class TeamMember extends Model
{
    use HasFactory;

    protected $table = 'team_members';

    protected $primaryKey = 'team_member_id';

    protected $fillable = [
        'team_id',
        'user_id',
        'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function team()
    {
        return $this->belongsTo(
            Team::class,
            'team_id',
            'team_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }
}