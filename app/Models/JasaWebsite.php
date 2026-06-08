<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JasaWebsite extends Model
{
    use HasFactory;

    protected $table = 'jasa_website_packages';

    protected $fillable = [
        'nama_paket',
        'harga_mulai',
        'fitur_list',
        'deskripsi_singkat',
        'is_active',
        'badge'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
