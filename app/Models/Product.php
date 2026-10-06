<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand',
        'model_series',
        'serial_number',
        'processor',
        'ram',
        'storage',
        'screen_size',
        'battery_health',
        'battery_runtime',
        'condition',
        'purchase_price',
        'selling_price',
        'original_price',
        'operational_cost',
        'status',
        'stock',
        'tipe_stok',
        'image_path',
        'description',
        'gallery_images',
        'ownership_type',
        'investor_id',
        'views_count',
        'is_banner_hero',
        'is_promo_utama',
        'video_url',
        'video_path',
    ];

    protected $casts = [
        'screen_size' => 'float',
        'battery_health' => 'integer',
        'battery_runtime' => 'float',
        'purchase_price' => 'integer',
        'selling_price'  => 'integer',
        'gallery_images' => 'array',
        'investor_id'    => 'integer',
        'is_banner_hero' => 'boolean',
        'is_promo_utama' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function investor()
    {
        return $this->belongsTo(Investor::class);
    }

    // -------------------------------------------------------
    // Image Resolution & Accessors (Responsive & WebP Support)
    // -------------------------------------------------------

    /**
     * Resolve image URL (prefer WebP version if exists on disk).
     */
    public static function resolveImageUrl(?string $imagePath): string
    {
        if (!$imagePath) {
            return asset('images/LKtech-fallback.webp');
        }

        $checkPath = preg_replace('/^public\//', '', $imagePath);

        // Cek varian WebP terlebih dahulu
        $webpPath = preg_replace('/\.(jpe?g|jfif|png)$/i', '.webp', $checkPath);
        if ($webpPath !== $checkPath && (Storage::disk('public')->exists($webpPath) || file_exists(public_path('storage/' . $webpPath)))) {
            return asset('storage/' . $webpPath);
        }

        // Cek file asli
        if (Storage::disk('public')->exists($checkPath) || file_exists(public_path('storage/' . $checkPath))) {
            return asset('storage/' . $checkPath);
        }

        if (file_exists(public_path($checkPath))) {
            return asset($checkPath);
        }

        if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://') || str_starts_with($imagePath, '/')) {
            return $imagePath;
        }

        return asset('images/LKtech-fallback.webp');
    }

    /**
     * Resolve thumbnail URL (prefer _thumb.webp if exists, fallback ke display_image).
     */
    public static function resolveThumbnailUrl(?string $imagePath): string
    {
        if (!$imagePath) {
            return asset('images/LKtech-fallback.webp');
        }

        $checkPath = preg_replace('/^public\//', '', $imagePath);

        // Cek apakah ada file versi _thumb.webp
        $thumbPath = preg_replace('/\.(jpe?g|jfif|png|webp)$/i', '_thumb.webp', $checkPath);
        if (Storage::disk('public')->exists($thumbPath) || file_exists(public_path('storage/' . $thumbPath))) {
            return asset('storage/' . $thumbPath);
        }

        // Jika path sudah bertuliskan _thumb
        if (str_contains($checkPath, '_thumb.') && (Storage::disk('public')->exists($checkPath) || file_exists(public_path('storage/' . $checkPath)))) {
            return asset('storage/' . $checkPath);
        }

        return self::resolveImageUrl($imagePath);
    }

    /**
     * Accessor untuk gambar utama produk.
     */
    public function getDisplayImageAttribute()
    {
        if (isset($this->attributes['display_image']) && !empty($this->attributes['display_image'])) {
            return $this->attributes['display_image'];
        }
        return self::resolveImageUrl($this->image_path);
    }

    /**
     * Accessor untuk thumbnail responsif produk.
     */
    public function getDisplayThumbnailAttribute()
    {
        if (isset($this->attributes['display_thumbnail']) && !empty($this->attributes['display_thumbnail'])) {
            return $this->attributes['display_thumbnail'];
        }
        return self::resolveThumbnailUrl($this->image_path);
    }

    // -------------------------------------------------------
    // Query Scopes
    // -------------------------------------------------------

    /**
     * Produk milik LKTech sendiri.
     */
    public function scopeLkTech($query)
    {
        return $query->where('ownership_type', 'lktech');
    }

    /**
     * Produk milik investor (any).
     */
    public function scopeOwnedByInvestor($query)
    {
        return $query->where('ownership_type', 'investor');
    }

    /**
     * Produk milik investor tertentu.
     */
    public function scopeByInvestor($query, int $investorId)
    {
        return $query->where('investor_id', $investorId);
    }

    /**
     * Produk yang tampil di banner promo hero slider.
     */
    public function scopeBannerHero($query)
    {
        return $query->where('is_banner_hero', true)
                     ->where('stock', '>', 0)
                     ->where('status', '!=', 'sold');
    }

    /**
     * Produk promo utama (Hot Promo).
     */
    public function scopePromoUtama($query)
    {
        return $query->where('is_promo_utama', true)
                     ->where('stock', '>', 0)
                     ->where('status', '!=', 'sold');
    }
}
