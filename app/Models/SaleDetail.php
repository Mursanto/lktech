<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'price_at_transaction' => 'integer',
        'purchase_price' => 'integer',
        'profit' => 'integer',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Hitung proporsi diskon / potongan untuk item ini dari transaksi induk.
     */
    public function getDiscountAmountAttribute(): int
    {
        $sale = $this->sale;
        if (!$sale || empty($sale->discount) || $sale->discount <= 0) {
            return 0;
        }

        $itemGross = ($this->price_at_transaction ?? 0) * ($this->quantity ?? 1);

        $saleSubtotal = $sale->subtotal > 0 
            ? $sale->subtotal 
            : ($sale->saleDetails()->count() > 0 
                ? $sale->saleDetails->sum(fn($d) => ($d->price_at_transaction ?? 0) * ($d->quantity ?? 1))
                : $itemGross);

        if ($saleSubtotal <= 0) {
            return (int) $sale->discount;
        }

        return (int) round(($itemGross / $saleSubtotal) * $sale->discount);
    }

    /**
     * Total harga jual bersih (Nett) untuk seluruh qty item ini (setelah diskon).
     */
    public function getNetTotalPriceAttribute(): int
    {
        $itemGross = ($this->price_at_transaction ?? 0) * ($this->quantity ?? 1);
        return max(0, $itemGross - $this->discount_amount);
    }

    /**
     * Harga jual bersih per unit (Nett per unit).
     */
    public function getNetPricePerUnitAttribute(): int
    {
        $qty = ($this->quantity && $this->quantity > 0) ? $this->quantity : 1;
        return (int) round($this->net_total_price / $qty);
    }

    /**
     * Profit Bersih Riil (setelah dipotong diskon/potongan).
     * Rumus: Total Harga Jual Bersih (Nett) - Total Modal
     *        Atau: (Harga Jual Normal - Diskon/Potongan) - Modal Unit
     */
    public function getNetProfitAttribute(): int
    {
        $totalModal = ($this->purchase_price ?? 0) * ($this->quantity ?? 1);

        // Jika transaksi memiliki diskon, hitung langsung dari harga jual nett dikurangi modal
        if ($this->discount_amount > 0) {
            return $this->net_total_price - $totalModal;
        }

        // Jika tidak ada diskon di transaksi induk
        if ($this->profit !== null) {
            return (int) $this->profit;
        }

        $itemGross = ($this->price_at_transaction ?? 0) * ($this->quantity ?? 1);
        return $itemGross - $totalModal;
    }
}
