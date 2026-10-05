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

        $clean = preg_replace('/^public\//', '', $this->thumbnail);

        $webpPath = preg_replace('/\.(jpe?g|png)$/i', '.webp', $clean);
        if ($webpPath !== $clean && (\Illuminate\Support\Facades\Storage::disk('public')->exists($webpPath) || file_exists(public_path('storage/' . $webpPath)))) {
            return asset('storage/' . $webpPath);
        }

        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($clean) || file_exists(public_path('storage/' . $clean))) {
            return asset('storage/' . $clean);
        }

        if (file_exists(public_path($clean))) {
            return asset($clean);
        }

        return asset('storage/' . $clean);
    }
}
