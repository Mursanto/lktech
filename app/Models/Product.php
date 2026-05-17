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
        'image_path',
        'description',
        'gallery_images',
    ];

    protected $casts = [
        'screen_size' => 'float',
        'battery_health' => 'integer',
        'battery_runtime' => 'float',
        'purchase_price' => 'integer',
        'selling_price' => 'integer',
        'gallery_images' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
