<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;

class FixProfitCalculationSeeder extends Seeder
{
    /**
     * Run the database seeds to fix profit calculations.
     */
    public function run()
    {
        $this->command->info('Starting profit calculation fix...');
        
        // Get all sales with their details
        $sales = Sale::with(['saleDetails.product'])->get();
        
        $totalSalesFixed = 0;
        $totalProfitCorrection = 0;
        
        foreach ($sales as $sale) {
            $originalProfit = $sale->profit_amount;
            $newTotalProfit = 0;
            
            // Update each sale detail with correct purchase price and profit
            foreach ($sale->saleDetails as $detail) {
                $product = $detail->product;
                $sellingPrice = $detail->price_at_transaction;
                $purchasePrice = $product->purchase_price;
                $profit = $sellingPrice - $purchasePrice;
                
                // Update sale detail
                $detail->update([
                    'purchase_price' => $purchasePrice,
                    'profit' => $profit,
                ]);
                
                $newTotalProfit += $profit;
                
                $this->command->info("Updated Sale #{$sale->id} - Product: {$product->brand} {$product->model_series}");
                $this->command->info("  Selling Price: Rp " . number_format($sellingPrice, 0, ',', '.'));
                $this->command->info("  Purchase Price: Rp " . number_format($purchasePrice, 0, ',', '.'));
                $this->command->info("  Profit: Rp " . number_format($profit, 0, ',', '.'));
                $this->command->info("---");
            }
            
            // Update sale total profit
            $sale->update([
                'profit_amount' => $newTotalProfit,
            ]);
            
            $profitCorrection = $newTotalProfit - $originalProfit;
            $totalProfitCorrection += $profitCorrection;
            $totalSalesFixed++;
            
            $this->command->info("Sale #{$sale->id} - Original Profit: Rp " . number_format($originalProfit, 0, ',', '.') . 
                                " -> New Profit: Rp " . number_format($newTotalProfit, 0, ',', '.') . 
                                " (Correction: Rp " . number_format($profitCorrection, 0, ',', '.') . ")");
            $this->command->info("========================================");
        }
        
        $this->command->info("Profit calculation fix completed!");
        $this->command->info("Total sales fixed: {$totalSalesFixed}");
        $this->command->info("Total profit correction: Rp " . number_format($totalProfitCorrection, 0, ',', '.'));
    }
}
