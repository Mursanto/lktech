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
        $endDate   = $request->input('end_date');

        // =====================================================
        // SALES DATA — hanya yang sudah LUNAS (payment_status = success)
        // =====================================================
        $salesQuery = \App\Models\Sale::with('saleDetails.product')
            ->where('payment_status', 'success')
            ->orderBy('created_at', 'desc');

        if ($startDate && $endDate) {
            $salesQuery->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        } else {
            $salesQuery->whereMonth('created_at', now()->month)
                       ->whereYear('created_at', now()->year);
        }

        $sales = $salesQuery->get();

        // Sales Totals
        $totalPenjualan        = $sales->sum('total_amount');
        $totalLabaBersih       = $sales->sum('profit_amount');
        $totalBiayaOperasional = $sales->sum(fn($s) => $s->operational_cost ?? 0);
        $totalLabaKotor        = $totalLabaBersih + $totalBiayaOperasional;
        $totalModal            = $totalPenjualan - $totalLabaKotor;

        // =====================================================
        // SERVICE DATA — hanya yang sudah LUNAS (payment_status = success)
        // =====================================================
        $serviceQuery = \App\Models\Service::with('customer')
            ->where('payment_status', 'success')
            ->orderBy('created_at', 'desc');

        if ($startDate && $endDate) {
            $serviceQuery->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        } else {
            $serviceQuery->whereMonth('created_at', now()->month)
                         ->whereYear('created_at', now()->year);
        }

        $services = $serviceQuery->get();

        // Service Totals:
        // - total_pendapatan = actual_cost (biaya servis sesungguhnya yang dibayar)
        // - laba_service = actual_cost - estimated_parts_cost (biaya jasa murni)
        $totalPendapatanService = $services->sum('actual_cost');
        $totalLabaService       = $services->sum(fn($s) => ($s->actual_cost ?? 0) - ($s->estimated_parts_cost ?? 0));

        // =====================================================
        // RENTAL DATA — hanya yang sudah LUNAS (payment_status = success)
        // =====================================================
        $rentalQuery = \App\Models\Rental::with('customer')
            ->where('payment_status', 'success')
            ->orderBy('created_at', 'desc');

        if ($startDate && $endDate) {
            $rentalQuery->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        } else {
            $rentalQuery->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year);
        }

        $rentals = $rentalQuery->get();

        // Rental Totals (seluruh total_price = pendapatan, tidak ada HPP)
        $totalPendapatanSewa = $rentals->sum('total_price');

        // =====================================================
        // MONTH-OVER-MONTH (MoM) — SALES (hanya yang lunas)
        // =====================================================
        $currentMonthSales  = \App\Models\Sale::where('payment_status', 'success')
                                              ->whereMonth('created_at', now()->month)
                                              ->whereYear('created_at', now()->year)->get();
        $previousMonthSales = \App\Models\Sale::where('payment_status', 'success')
                                              ->whereMonth('created_at', now()->subMonth()->month)
                                              ->whereYear('created_at', now()->subMonth()->year)->get();

        $cmPendapatan = $currentMonthSales->sum('total_amount');
        $cmLaba       = $currentMonthSales->sum('profit_amount');
        $cmModal      = $cmPendapatan - $cmLaba;

        $pmPendapatan = $previousMonthSales->sum('total_amount');
        $pmLaba       = $previousMonthSales->sum('profit_amount');
        $pmModal      = $pmPendapatan - $pmLaba;

        $growthPendapatan = $pmPendapatan > 0 ? (($cmPendapatan - $pmPendapatan) / $pmPendapatan) * 100 : ($cmPendapatan > 0 ? 100 : 0);
        $growthModal      = $pmModal > 0 ? (($cmModal - $pmModal) / $pmModal) * 100 : ($cmModal > 0 ? 100 : 0);
        $growthLaba       = $pmLaba > 0 ? (($cmLaba - $pmLaba) / $pmLaba) * 100 : ($cmLaba > 0 ? 100 : 0);

        // =====================================================
        // MONTH-OVER-MONTH (MoM) — SERVICE (hanya yang lunas)
        // =====================================================
        $currentMonthServices  = \App\Models\Service::where('payment_status', 'success')
                                                    ->whereMonth('created_at', now()->month)
                                                    ->whereYear('created_at', now()->year)->get();
        $previousMonthServices = \App\Models\Service::where('payment_status', 'success')
                                                    ->whereMonth('created_at', now()->subMonth()->month)
                                                    ->whereYear('created_at', now()->subMonth()->year)->get();

        $cmService    = $currentMonthServices->sum('actual_cost');
        $pmService    = $previousMonthServices->sum('actual_cost');
        $growthService = $pmService > 0 ? (($cmService - $pmService) / $pmService) * 100 : ($cmService > 0 ? 100 : 0);

        // =====================================================
        // MONTH-OVER-MONTH (MoM) — RENTAL (hanya yang lunas)
        // =====================================================
        $currentMonthRentals  = \App\Models\Rental::where('payment_status', 'success')
                                                  ->whereMonth('created_at', now()->month)
                                                  ->whereYear('created_at', now()->year)->get();
        $previousMonthRentals = \App\Models\Rental::where('payment_status', 'success')
                                                  ->whereMonth('created_at', now()->subMonth()->month)
                                                  ->whereYear('created_at', now()->subMonth()->year)->get();

        $cmRental    = $currentMonthRentals->sum('total_price');
        $pmRental    = $previousMonthRentals->sum('total_price');
        $growthRental = $pmRental > 0 ? (($cmRental - $pmRental) / $pmRental) * 100 : ($cmRental > 0 ? 100 : 0);

        return view('reports.index', compact(
            // Sales data
            'sales', 'totalPenjualan', 'totalModal', 'totalLabaKotor', 'totalBiayaOperasional', 'totalLabaBersih',
            // Service data
            'services', 'totalPendapatanService', 'totalLabaService',
            // Rental data
            'rentals', 'totalPendapatanSewa',
            // MoM Sales
            'cmPendapatan', 'cmModal', 'cmLaba',
            'pmPendapatan', 'pmModal', 'pmLaba',
            'growthPendapatan', 'growthModal', 'growthLaba',
            // MoM Service
            'cmService', 'pmService', 'growthService',
            // MoM Rental
            'cmRental', 'pmRental', 'growthRental'
        ));
    }

    public function profit()
    {
        // Ambil data penjualan terbaru beserta relasi produknya
        $sales = \App\Models\Sale::with('product')->orderBy('created_at', 'desc')->get();

        // Kalkulasi Total secara Real-time (Keseluruhan)
        $totalPendapatan = $sales->sum('total_amount');
        $totalLaba       = $sales->sum('profit_amount');
        $totalModal      = $totalPendapatan - $totalLaba;

        // --- Month-over-Month (MoM) Calculation ---
        $currentMonthSales  = \App\Models\Sale::whereMonth('created_at', now()->month)
                                             ->whereYear('created_at', now()->year)->get();
        $previousMonthSales = \App\Models\Sale::whereMonth('created_at', now()->subMonth()->month)
                                             ->whereYear('created_at', now()->subMonth()->year)->get();

        $cmPendapatan = $currentMonthSales->sum('total_amount');
        $cmLaba       = $currentMonthSales->sum('profit_amount');
        $cmModal      = $cmPendapatan - $cmLaba;

        $pmPendapatan = $previousMonthSales->sum('total_amount');
        $pmLaba       = $previousMonthSales->sum('profit_amount');
        $pmModal      = $pmPendapatan - $pmLaba;

        $growthPendapatan = $pmPendapatan > 0 ? (($cmPendapatan - $pmPendapatan) / $pmPendapatan) * 100 : ($cmPendapatan > 0 ? 100 : 0);
        $growthModal      = $pmModal > 0 ? (($cmModal - $pmModal) / $pmModal) * 100 : ($cmModal > 0 ? 100 : 0);
        $growthLaba       = $pmLaba > 0 ? (($cmLaba - $pmLaba) / $pmLaba) * 100 : ($cmLaba > 0 ? 100 : 0);

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
