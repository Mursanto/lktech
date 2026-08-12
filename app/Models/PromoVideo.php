<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoVideo extends Model
{
    protected $fillable = [
        'title',
        'video_path',
        'target_url',
        'is_active',
    ];
}
