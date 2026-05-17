<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;

class ProfitAuditController extends Controller
{
    /**
     * Perform comprehensive profit audit and recalculation
     */
    public function auditAndRecalculateAll()
    {
        $this->commandInfo('Starting comprehensive profit audit and recalculation...');
        
        try {
            DB::beginTransaction();
            
            // Get all sales with their details
            $sales = Sale::with(['saleDetails.product'])->get();
            
            $totalSalesProcessed = 0;
            $totalProfitCorrection = 0;
            $auditResults = [];
            
            foreach ($sales as $sale) {
                $originalProfit = $sale->profit_amount;
                $newTotalProfit = 0;
                $saleDetails = [];
                
                // Recalculate each sale detail with strict formula
                foreach ($sale->saleDetails as $detail) {
                    $product = $detail->product;
                    $sellingPrice = $detail->price_at_transaction;
                    $purchasePrice = $product->purchase_price;
                    $calculatedProfit = $sellingPrice - $purchasePrice;
                    
                    // Update sale detail with correct values
                    $detail->update([
                        'purchase_price' => $purchasePrice,
                        'profit' => $calculatedProfit,
                    ]);
                    
                    $newTotalProfit += $calculatedProfit;
                    
                    $saleDetails[] = [
                        'product' => $product->brand . ' ' . $product->model_series,
                        'selling_price' => $sellingPrice,
                        'purchase_price' => $purchasePrice,
                        'calculated_profit' => $calculatedProfit,
                    ];
                }
                
                // Update sale total profit
                $sale->update([
                    'profit_amount' => $newTotalProfit,
                ]);
                
                $profitCorrection = $newTotalProfit - $originalProfit;
                $totalProfitCorrection += $profitCorrection;
                $totalSalesProcessed++;
                
                $auditResults[] = [
                    'sale_id' => $sale->id,
                    'original_profit' => $originalProfit,
                    'new_profit' => $newTotalProfit,
                    'correction' => $profitCorrection,
                    'details' => $saleDetails,
                ];
                
                $this->commandInfo("Sale #{$sale->id}: " . 
                    "Original: Rp " . number_format($originalProfit, 0, ',', '.') . 
                    " -> New: Rp " . number_format($newTotalProfit, 0, ',', '.') . 
                    " (Correction: Rp " . number_format($profitCorrection, 0, ',', '.') . ")");
            }
            
            DB::commit();
            
            $this->commandInfo("Profit audit completed successfully!");
            $this->commandInfo("Total sales processed: {$totalSalesProcessed}");
            $this->commandInfo("Total profit correction: Rp " . number_format($totalProfitCorrection, 0, ',', '.'));
            
            return response()->json([
                'success' => true,
                'message' => 'Profit audit and recalculation completed',
                'data' => [
                    'total_sales_processed' => $totalSalesProcessed,
                    'total_profit_correction' => $totalProfitCorrection,
                    'audit_results' => $auditResults,
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->commandInfo("Error during profit audit: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error during profit audit: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Validate dashboard calculations
     */
    public function validateDashboardCalculations()
    {
        $this->commandInfo('Validating dashboard calculations...');
        
        // Calculate using sales method (actual transactions)
        $totalOmzetFromSales = Sale::sum('total_amount');
        $totalLabaFromSales = Sale::sum('profit_amount');
        
        // Calculate using products method (for comparison)
        $totalOmzetFromProducts = Product::where('status', 'sold')->sum('selling_price');
        $totalLabaFromProducts = Product::where('status', 'sold')->sum(\DB::raw('selling_price - purchase_price'));
        
        $validationResults = [
            'sales_method' => [
                'total_omzet' => $totalOmzetFromSales,
                'total_laba' => $totalLabaFromSales,
            ],
            'products_method' => [
                'total_omzet' => $totalOmzetFromProducts,
                'total_laba' => $totalLabaFromProducts,
            ],
            'differences' => [
                'omzet_difference' => $totalOmzetFromSales - $totalOmzetFromProducts,
                'laba_difference' => $totalLabaFromSales - $totalLabaFromProducts,
            ],
        ];
        
        $this->commandInfo("Sales Method - Omzet: Rp " . number_format($totalOmzetFromSales, 0, ',', '.') . 
                          ", Laba: Rp " . number_format($totalLabaFromSales, 0, ',', '.'));
        $this->commandInfo("Products Method - Omzet: Rp " . number_format($totalOmzetFromProducts, 0, ',', '.') . 
                          ", Laba: Rp " . number_format($totalLabaFromProducts, 0, ',', '.'));
        $this->commandInfo("Differences - Omzet: Rp " . number_format($validationResults['differences']['omzet_difference'], 0, ',', '.') . 
                          ", Laba: Rp " . number_format($validationResults['differences']['laba_difference'], 0, ',', '.'));
        
        return response()->json([
            'success' => true,
            'message' => 'Dashboard validation completed',
            'data' => $validationResults
        ]);
    }
    
    /**
     * Recalculate profit for specific sale
     */
    public function recalculateSaleProfit($saleId)
    {
        $sale = Sale::with(['saleDetails.product'])->findOrFail($saleId);
        
        try {
            DB::beginTransaction();
            
            $originalProfit = $sale->profit_amount;
            $newTotalProfit = 0;
            
            foreach ($sale->saleDetails as $detail) {
                $product = $detail->product;
                $sellingPrice = $detail->price_at_transaction;
                $purchasePrice = $product->purchase_price;
                $calculatedProfit = $sellingPrice - $purchasePrice;
                
                $detail->update([
                    'purchase_price' => $purchasePrice,
                    'profit' => $calculatedProfit,
                ]);
                
                $newTotalProfit += $calculatedProfit;
            }
            
            $sale->update([
                'profit_amount' => $newTotalProfit,
            ]);
            
            DB::commit();
            
            $profitCorrection = $newTotalProfit - $originalProfit;
            
            return response()->json([
                'success' => true,
                'message' => "Sale #{$saleId} profit recalculated",
                'data' => [
                    'original_profit' => $originalProfit,
                    'new_profit' => $newTotalProfit,
                    'correction' => $profitCorrection,
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error recalculating profit: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Helper method for command output
     */
    private function commandInfo($message)
    {
        if (app()->runningInConsole()) {
            echo $message . PHP_EOL;
        }
        \Log::info($message);
    }
}
