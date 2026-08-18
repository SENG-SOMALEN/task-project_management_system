<?php

namespace Modules\Collaboration\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Collaboration\Database\factories\AttachmentFactory;

class Attachment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    protected static function newFactory()
    {
        //return AttachmentFactory::new();
    }
}
