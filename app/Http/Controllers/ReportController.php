<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Exports\ProfitLossExport;
use Illuminate\Http\Request;
use Excel;

class ReportController extends Controller
{
    public function index()
    {
        // Memanggil relasi yang benar: saleDetails dan product-nya
    $sales = \App\Models\Sale::with('saleDetails.product')->orderBy('created_at', 'desc')->get();
        
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

        return view('reports.index', compact(
            'sales', 'totalPenjualan', 'totalModal', 'totalLabaKotor', 'totalBiayaOperasional', 'totalLabaBersih'
        ));
    }
    
    public function profit()
    {
        // Ambil data penjualan terbaru beserta relasi produknya
        $sales = \App\Models\Sale::with('product')->orderBy('created_at', 'desc')->get();
        
        // Kalkulasi Total secara Real-time
        $totalPendapatan = $sales->sum('total_amount');
        $totalLaba = $sales->sum('profit_amount');
        $totalModal = $totalPendapatan - $totalLaba;
        
        // Asumsi tambahan: Ambil data servis yang sudah 'done' jika ada labanya
        // $services = \App\Models\Service::where('status', 'done')->get();
        // ... tambahkan logika servis di sini jika database service memiliki kolom profit

        return view('reports.profit', compact('sales', 'totalPendapatan', 'totalModal', 'totalLaba'));
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
