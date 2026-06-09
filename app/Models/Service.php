<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'technician_id',
        'device_name',
        'serial_number',
        'equipment_details',
        'complaint',
        'status',
        'service_fee',
        'estimated_parts_cost',
        'actual_cost',
        'total_amount',
        'completion_date',
        'notes',
        'service_type',
        'description',
        'device_brand',
        'device_model',
        'issue_description',
        'estimated_cost',
        'devices',
    ];

    protected $casts = [
        'service_fee'          => 'decimal:2',
        'estimated_parts_cost' => 'decimal:2',
        'estimated_cost'       => 'decimal:2',
        'total_amount'         => 'decimal:2',
        'actual_cost'          => 'decimal:2',
        'completion_date'      => 'datetime',
        'devices'              => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(ServiceItem::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function parts()
    {
        return $this->hasMany(ServicePart::class);
    }

    public function sale()
    {
        return $this->hasOne(Sale::class);
    }

    public function getStatusColorAttribute()
    {
        return [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'process' => 'bg-blue-100 text-blue-800',
            'done' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
        ][$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getStatusBadgeAttribute()
    {
        return [
            'pending' => 'Menunggu',
            'process' => 'Proses',
            'done' => 'Selesai',
            'cancelled' => 'Batal',
        ][$this->status] ?? 'Unknown';
    }
}
