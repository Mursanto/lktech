<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'operational_cost',
        'status',
        'stock',
        'tipe_stok',
        'image_path',
        'description',
        'gallery_images',
        'ownership_type',
        'investor_id',
    ];

    protected $casts = [
        'screen_size' => 'float',
        'battery_health' => 'integer',
        'battery_runtime' => 'float',
        'purchase_price' => 'integer',
        'selling_price'  => 'integer',
        'gallery_images' => 'array',
        'investor_id'    => 'integer',
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
}
