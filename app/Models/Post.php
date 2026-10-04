<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getDisplayThumbnailAttribute()
    {
        if (!$this->thumbnail) {
            return asset('images/LKtech-fallback.webp');
        }

        $webpPath = preg_replace('/\.(jpe?g|png)$/i', '.webp', $this->thumbnail);
        if ($webpPath !== $this->thumbnail && \Illuminate\Support\Facades\Storage::disk('public')->exists($webpPath)) {
            return \Illuminate\Support\Facades\Storage::url($webpPath);
        }

        return \Illuminate\Support\Facades\Storage::url($this->thumbnail);
    }
}
