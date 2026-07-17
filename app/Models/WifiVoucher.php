<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WifiVoucher extends Model
{
    use HasFactory;

    protected $table = 'wifi_voucher_packages';

    protected $fillable = [
        'nama_paket',
        'harga',
        'fitur_list',
        'deskripsi_singkat',
        'is_active',
        'badge'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
