<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'share_percentage',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'share_percentage' => 'float',
        'is_active'        => 'boolean',
    ];

    /**
     * Semua produk yang dimiliki oleh investor ini.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Produk aktif (available) milik investor.
     */
    public function activeProducts()
    {
        return $this->hasMany(Product::class)->where('status', 'available');
    }

    /**
     * Total nilai aset stok aktif (qty × purchase_price).
     */
    public function totalAssetValue(): int
    {
        return (int) $this->activeProducts()
            ->get()
            ->sum(fn($p) => ($p->stock ?? 1) * ($p->purchase_price ?? 0));
    }

    /**
     * Total investasi awal (Total modal yang dikeluarkan untuk semua stok, baik terjual maupun sisa).
     */
    public function totalInvestmentValue(): int
    {
        return (int) $this->products()
            ->get()
            ->sum(function($p) {
                $soldQty = $p->saleDetails()->whereHas('sale', fn($q) => $q->where('payment_status', 'success'))->sum('quantity');
                $totalQty = $p->stock + $soldQty;
                return $totalQty * ($p->purchase_price ?? 0);
            });
    }

    /**
     * QTY Stok Awal (Total Keseluruhan)
     */
    public function totalQty(): int
    {
        return (int) $this->products()
            ->get()
            ->sum(function($p) {
                $soldQty = $p->saleDetails()->whereHas('sale', fn($q) => $q->where('payment_status', 'success'))->sum('quantity');
                return $p->stock + $soldQty;
            });
    }

    /**
     * QTY Terjual
     */
    public function soldQty(): int
    {
        return (int) $this->products()
            ->get()
            ->sum(function($p) {
                return $p->saleDetails()->whereHas('sale', fn($q) => $q->where('payment_status', 'success'))->sum('quantity');
            });
    }

    /**
     * QTY Sisa Stok
     */
    public function currentStockQty(): int
    {
        return (int) $this->activeProducts()->sum('stock');
    }

    /**
     * Total profit kotor dari penjualan produk investor.
     */
    public function totalGrossProfit(?string $startDate = null, ?string $endDate = null): int
    {
        $query = SaleDetail::whereHas('product', fn($q) => $q->where('investor_id', $this->id))
            ->whereHas('sale', fn($q) => $q->where('payment_status', 'success'));

        if ($startDate && $endDate) {
            $query->whereHas('sale', fn($q) => $q->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]));
        }

        return (int) $query->get()->sum(fn($d) => ($d->profit ?? 0));
    }

    /**
     * Bagian profit investor (gross profit × share%).
     */
    public function investorShareAmount(?string $startDate = null, ?string $endDate = null): int
    {
        return (int) round($this->totalGrossProfit($startDate, $endDate) * ($this->share_percentage / 100));
    }

    /**
     * Bagian profit LKTech dari produk investor.
     */
    public function lktechShareAmount(?string $startDate = null, ?string $endDate = null): int
    {
        return $this->totalGrossProfit($startDate, $endDate) - $this->investorShareAmount($startDate, $endDate);
    }
}
