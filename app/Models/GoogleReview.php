<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'google_review_id',
        'reviewer_name',
        'reviewer_photo_url',
        'star_rating',
        'review_comment',
        'review_created_at',
        'review_reply',
        'is_featured',
    ];

    protected $casts = [
        'review_created_at' => 'datetime',
        'is_featured' => 'boolean',
    ];
}
