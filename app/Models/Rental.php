<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_phone',
        'laptop_name',
        'serial_number',
        'manual_sn',
        'rental_date',
        'return_date',
        'daily_price',
        'total_price',
        'status',
        'notes',
        'payment_status',
        'payment_method',
        'payment_reference_id',
    ];

    protected $casts = [
        'rental_date'  => 'date',
        'return_date'  => 'date',
        'daily_price'  => 'decimal:2',
        'total_price'  => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'serial_number', 'serial_number');
    }

    public function isPaid()
    {
        return $this->payment_status === 'success';
    }
}
