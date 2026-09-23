<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
    protected $guarded = [];

    protected $casts = [
        'promo_banners'        => 'array',
        'promo_product_links'  => 'array',
        'is_promo_active'      => 'boolean',
    ];
}
