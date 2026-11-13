<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorDeposit extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'amount' => 'integer',
        'date'   => 'date',
    ];

    public function investor()
    {
        return $this->belongsTo(Investor::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

