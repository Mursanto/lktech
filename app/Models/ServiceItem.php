<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model
{
    protected $fillable = [
        'service_id',
        'device_name',
        'serial_number',
        'equipment_details',
        'complaint',
        'service_charge',
        'spareparts',
    ];

    protected $casts = [
        'service_charge' => 'decimal:2',
        'spareparts' => 'array',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
