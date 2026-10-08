<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Sale;
use App\Models\SaleDetail;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Sinkronkan ulang kalkulasi profit pada seluruh detail transaksi yang memiliki diskon/potongan.
     */
    public function up(): void
    {
        $sales = Sale::with('saleDetails')->get();

        foreach ($sales as $sale) {
            $details = $sale->saleDetails;
            if ($details->isEmpty()) {
                continue;
            }

            // Hitung subtotal kotor asli dari akumulasi item
            $calcSubtotal = $details->sum(function ($d) {
                return ($d->price_at_transaction ?? 0) * ($d->quantity ?? 1);
            });

            $discount = (int) ($sale->discount ?? 0);
            $subtotal = $sale->subtotal > 0 ? (int) $sale->subtotal : (int) $calcSubtotal;
            $grandTotal = max(0, $subtotal - $discount);

            $discountRemaining = $discount;
            $itemsCount = $details->count();
            $loopIndex = 0;
            $totalProfit = 0;

            foreach ($details as $detail) {
                $loopIndex++;
                $itemGross = ($detail->price_at_transaction ?? 0) * ($detail->quantity ?? 1);

                if ($loopIndex === $itemsCount) {
                    $itemDiscount = $discountRemaining;
                } else {
                    $itemDiscount = $subtotal > 0 ? (int) round(($itemGross / $subtotal) * $discount) : 0;
                    $discountRemaining -= $itemDiscount;
                }

                $modalTotal = ($detail->purchase_price ?? 0) * ($detail->quantity ?? 1);
                // Profit bersih = (Harga Jual Kotor - Diskon Item) - Total Modal
                $netProfit = ($itemGross - $itemDiscount) - $modalTotal;
                $totalProfit += $netProfit;

                $detail->update([
                    'profit' => $netProfit,
                ]);
            }

            $sale->update([
                'subtotal'      => $subtotal,
                'total_amount'  => $grandTotal,
                'profit_amount' => $totalProfit,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback needed for data normalization
    }
};
