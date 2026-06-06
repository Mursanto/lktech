<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Exports\ProfitLossExport;
use Illuminate\Http\Request;
use Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Base query
        $query = \App\Models\Sale::with('saleDetails.product')->orderBy('created_at', 'desc');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        } else {
            // Default to current month
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        }

        $sales = $query->get();
        
        // 1. Total Penjualan
        $totalPenjualan = $sales->sum('total_amount');
        
        // 2. Laba Bersih (mengambil dari profit_amount)
        $totalLabaBersih = $sales->sum('profit_amount');
        
        // 3. Biaya Operasional (Asumsi ada kolom operational_cost. Jika null, dianggap 0)
        $totalBiayaOperasional = $sales->sum(function ($sale) {
            return $sale->operational_cost ?? 0;
        });
        
        // 4. Laba Kotor = Laba Bersih + Biaya Operasional
        $totalLabaKotor = $totalLabaBersih + $totalBiayaOperasional;
        
        // 5. Total Modal (HPP) = Total Penjualan - Laba Kotor
        $totalModal = $totalPenjualan - $totalLabaKotor;

        // --- Month-over-Month (MoM) Calculation ---
        $currentMonthSales = \App\Models\Sale::whereMonth('created_at', now()->month)
                                             ->whereYear('created_at', now()->year)->get();
        $previousMonthSales = \App\Models\Sale::whereMonth('created_at', now()->subMonth()->month)
                                              ->whereYear('created_at', now()->subMonth()->year)->get();
                                              
        // Current Month Metrics
        $cmPendapatan = $currentMonthSales->sum('total_amount');
        $cmLaba = $currentMonthSales->sum('profit_amount');
        $cmModal = $cmPendapatan - $cmLaba;
        
        // Previous Month Metrics
        $pmPendapatan = $previousMonthSales->sum('total_amount');
        $pmLaba = $previousMonthSales->sum('profit_amount');
        $pmModal = $pmPendapatan - $pmLaba;
        
        // Growth Percentages
        $growthPendapatan = $pmPendapatan > 0 ? (($cmPendapatan - $pmPendapatan) / $pmPendapatan) * 100 : ($cmPendapatan > 0 ? 100 : 0);
        $growthModal = $pmModal > 0 ? (($cmModal - $pmModal) / $pmModal) * 100 : ($cmModal > 0 ? 100 : 0);
        $growthLaba = $pmLaba > 0 ? (($cmLaba - $pmLaba) / $pmLaba) * 100 : ($cmLaba > 0 ? 100 : 0);

        return view('reports.index', compact(
            'sales', 'totalPenjualan', 'totalModal', 'totalLabaKotor', 'totalBiayaOperasional', 'totalLabaBersih',
            'cmPendapatan', 'cmModal', 'cmLaba',
            'pmPendapatan', 'pmModal', 'pmLaba',
            'growthPendapatan', 'growthModal', 'growthLaba'
        ));
    }
    
    public function profit()
    {
        // Ambil data penjualan terbaru beserta relasi produknya
        $sales = \App\Models\Sale::with('product')->orderBy('created_at', 'desc')->get();
        
        // Kalkulasi Total secara Real-time (Keseluruhan)
        $totalPendapatan = $sales->sum('total_amount');
        $totalLaba = $sales->sum('profit_amount');
        $totalModal = $totalPendapatan - $totalLaba;
        
        // --- Month-over-Month (MoM) Calculation ---
        $currentMonthSales = \App\Models\Sale::whereMonth('created_at', now()->month)
                                             ->whereYear('created_at', now()->year)->get();
        $previousMonthSales = \App\Models\Sale::whereMonth('created_at', now()->subMonth()->month)
                                              ->whereYear('created_at', now()->subMonth()->year)->get();
                                              
        // Current Month Metrics
        $cmPendapatan = $currentMonthSales->sum('total_amount');
        $cmLaba = $currentMonthSales->sum('profit_amount');
        $cmModal = $cmPendapatan - $cmLaba;
        
        // Previous Month Metrics
        $pmPendapatan = $previousMonthSales->sum('total_amount');
        $pmLaba = $previousMonthSales->sum('profit_amount');
        $pmModal = $pmPendapatan - $pmLaba;
        
        // Growth Percentages
        $growthPendapatan = $pmPendapatan > 0 ? (($cmPendapatan - $pmPendapatan) / $pmPendapatan) * 100 : ($cmPendapatan > 0 ? 100 : 0);
        $growthModal = $pmModal > 0 ? (($cmModal - $pmModal) / $pmModal) * 100 : ($cmModal > 0 ? 100 : 0);
        $growthLaba = $pmLaba > 0 ? (($cmLaba - $pmLaba) / $pmLaba) * 100 : ($cmLaba > 0 ? 100 : 0);

        return view('reports.profit', compact(
            'sales', 'totalPendapatan', 'totalModal', 'totalLaba',
            'cmPendapatan', 'cmModal', 'cmLaba',
            'pmPendapatan', 'pmModal', 'pmLaba',
            'growthPendapatan', 'growthModal', 'growthLaba'
        ));
    }

    public function export()
    {
        return Excel::download(new ProfitLossExport, 'laba_rugi.xlsx');
    }

    public function profitLossExport()
    {
        return Excel::download(new ProfitLossExport, 'laba_rugi_detail.xlsx');
    }
}
