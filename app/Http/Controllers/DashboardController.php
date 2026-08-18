<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Rincian Stok Berdasarkan Kategori
        $stokDevice = \App\Models\Product::where('status', 'available')->whereHas('category', function($q) { 
            $q->where('name', 'Laptop & Device')->orWhereHas('parent', function($q2) { $q2->where('name', 'Laptop & Device'); });
        })->sum('stock');

        $stokSparepart = \App\Models\Product::where('status', 'available')->whereHas('category', function($q) { 
            $q->where('name', 'Komponen & Sparepart')->orWhereHas('parent', function($q2) { $q2->where('name', 'Komponen & Sparepart'); });
        })->sum('stock');

        $stokAksesoris = \App\Models\Product::where('status', 'available')->whereHas('category', function($q) { 
            $q->where('name', 'Aksesoris')->orWhereHas('parent', function($q2) { $q2->where('name', 'Aksesoris'); });
        })->sum('stock');

        $stokSoftware = \App\Models\Product::where('status', 'available')->whereHas('category', function($q) { 
            $q->where('name', 'Lisensi & Software')->orWhereHas('parent', function($q2) { $q2->where('name', 'Lisensi & Software'); });
        })->sum('stock');

        // Total Stok Utama: menjumlahkan seluruh kolom stock dari tabel products yang memiliki status = 'available'
        $totalStok = \App\Models\Product::where('status', 'available')->sum('stock');

        // 2. Rincian Status Servis
        $totalServis = \App\Models\Service::count();
        $servisPending = \App\Models\Service::where('status', 'pending')->count();
        $servisProcess = \App\Models\Service::where('status', 'process')->count();
        $servisDone = \App\Models\Service::where('status', 'done')->count();
        $servisCancelled = \App\Models\Service::where('status', 'cancelled')->count();

        // 3. Data Grafik Trend 3 Bulan Terakhir (Penjualan & Laba)
        $salesTrend = [];
        $profitTrend = [];
        $trendLabels = [];
        for ($i = 2; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $trendLabels[] = $month->translatedFormat('M Y');
            
            $saleSum = \App\Models\Sale::where('payment_status', 'success')->whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->sum('total_amount');
            $serviceSum = \App\Models\Service::where('payment_status', 'success')->whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->sum('actual_cost');
            $rentalSum = \App\Models\Rental::where('payment_status', 'success')->whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->sum('total_price');
            $salesTrend[] = $saleSum + $serviceSum + $rentalSum;
            
            $saleProfit = \App\Models\Sale::where('payment_status', 'success')->whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->sum('profit_amount');
            $serviceProfit = \App\Models\Service::where('payment_status', 'success')->whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->get()->sum(function($s) {
                return $s->actual_cost - $s->estimated_parts_cost;
            });
            $rentalProfit = \App\Models\Rental::where('payment_status', 'success')->whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->sum('total_price');
            $profitTrend[] = $saleProfit + $serviceProfit + $rentalProfit;
        }

        // Data Stok Unit Device Menipis (Max 5)
        $lowUnitDevice = \App\Models\Product::with('category')->where('status', 'available')
            ->whereHas('category', function($q) {
                $q->where('name', 'Laptop & Device')->orWhereHas('parent', function($q2) { $q2->where('name', 'Laptop & Device'); });
            })->where('stock', '>', 0)->orderBy('stock', 'asc')->limit(5)->get();

        // Data Stok Sparepart Menipis (Max 5)
        $lowSparepart = \App\Models\Product::with('category')->where('status', 'available')
            ->whereHas('category', function($q) {
                $q->where('name', 'Komponen & Sparepart')->orWhereHas('parent', function($q2) { $q2->where('name', 'Komponen & Sparepart'); });
            })->where('stock', '>', 0)->orderBy('stock', 'asc')->limit(5)->get();

        // Data Stok Aksesoris Menipis (Max 3)
        $lowAksesoris = \App\Models\Product::with('category')->where('status', 'available')
            ->whereHas('category', function($q) {
                $q->where('name', 'Aksesoris')->orWhereHas('parent', function($q2) { $q2->where('name', 'Aksesoris'); });
            })->where('stock', '>', 0)->orderBy('stock', 'asc')->limit(3)->get();

        // Data Stok Software Menipis (Max 3)
        $lowSoftware = \App\Models\Product::with('category')->where('status', 'available')
            ->whereHas('category', function($q) {
                $q->where('name', 'Lisensi & Software')->orWhereHas('parent', function($q2) { $q2->where('name', 'Lisensi & Software'); });
            })->where('stock', '>', 0)->orderBy('stock', 'asc')->limit(3)->get();

        // 4. Data Sewa Laptop
        $totalSewa = 0;
        $sewaAktif = 0;
        $sewaSelesai = 0;
        $sewaTerlambat = 0;
        try {
            $totalSewa = \App\Models\Rental::count();
            $sewaAktif = \App\Models\Rental::where('status', 'active')->whereDate('return_date', '>=', now())->count();
            $sewaSelesai = \App\Models\Rental::where('status', 'completed')->count();
            $sewaTerlambat = \App\Models\Rental::where('status', 'overdue')
                                ->orWhere(function($query) {
                                    $query->where('status', 'active')
                                          ->whereDate('return_date', '<', now());
                                })->count();
        } catch (\Exception $e) {
            // Rental model might not exist or table not created
        }

        // 5. Perbandingan Omzet & Laba (Bulan Ini vs Bulan Lalu)
        $saleOmzetBulanIni = \App\Models\Sale::where('payment_status', 'success')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total_amount');
        $serviceOmzetBulanIni = \App\Models\Service::where('payment_status', 'success')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('actual_cost');
        $rentalOmzetBulanIni = \App\Models\Rental::where('payment_status', 'success')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total_price');
        $omzetBulanIni = $saleOmzetBulanIni + $serviceOmzetBulanIni + $rentalOmzetBulanIni;

        $saleOmzetBulanLalu = \App\Models\Sale::where('payment_status', 'success')->whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->sum('total_amount');
        $serviceOmzetBulanLalu = \App\Models\Service::where('payment_status', 'success')->whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->sum('actual_cost');
        $rentalOmzetBulanLalu = \App\Models\Rental::where('payment_status', 'success')->whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->sum('total_price');
        $omzetBulanLalu = $saleOmzetBulanLalu + $serviceOmzetBulanLalu + $rentalOmzetBulanLalu;
        
        $saleLabaBulanIni = \App\Models\Sale::where('payment_status', 'success')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('profit_amount');
        $serviceLabaBulanIni = \App\Models\Service::where('payment_status', 'success')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->get()->sum(function($s) {
            return $s->actual_cost - $s->estimated_parts_cost;
        });
        $rentalLabaBulanIni = \App\Models\Rental::where('payment_status', 'success')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total_price');
        $labaBulanIni = $saleLabaBulanIni + $serviceLabaBulanIni + $rentalLabaBulanIni;

        $saleLabaBulanLalu = \App\Models\Sale::where('payment_status', 'success')->whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->sum('profit_amount');
        $serviceLabaBulanLalu = \App\Models\Service::where('payment_status', 'success')->whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->get()->sum(function($s) {
            return $s->actual_cost - $s->estimated_parts_cost;
        });
        $rentalLabaBulanLalu = \App\Models\Rental::where('payment_status', 'success')->whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->sum('total_price');
        $labaBulanLalu = $saleLabaBulanLalu + $serviceLabaBulanLalu + $rentalLabaBulanLalu;

        // Pertumbuhan Persentase MoM
        $omzetGrowth = $omzetBulanLalu > 0 ? (($omzetBulanIni - $omzetBulanLalu) / $omzetBulanLalu) * 100 : ($omzetBulanIni > 0 ? 100 : 0);
        $labaGrowth = $labaBulanLalu > 0 ? (($labaBulanIni - $labaBulanLalu) / $labaBulanLalu) * 100 : ($labaBulanIni > 0 ? 100 : 0);

        $visitorCount = 0;
        try {
            $visitorCount = \App\Models\CatalogVisitor::whereMonth('visited_at', now()->month)
                                                      ->whereYear('visited_at', now()->year)
                                                      ->count();
        } catch (\Exception $e) {
            // Ignore error if table is not yet migrated
        }

        return view('dashboard', [
            'visitorCount' => $visitorCount,
            'totalOmzet' => $omzetBulanIni, // Tampilkan bulan ini sebagai default total
            'totalLaba' => $labaBulanIni, // Tampilkan bulan ini sebagai default total
            'totalStok' => $totalStok,
            'stokHabis' => \App\Models\Product::where('stock', '<=', 0)->count(),
            'servisPending' => $servisPending,
            'servisProcess' => $servisProcess,
            'servisDoneToday' => \App\Models\Service::where('status', 'done')->whereDate('updated_at', now())->count(),
            'stokRendah' => \App\Models\Product::where('stock', '>', 0)->orderBy('stock', 'asc')->limit(5)->get(),
            'gamingStock' => 0, 
            'officeStock' => 0, 
            'ultrabookStock' => 0, 
            'stokDevice' => $stokDevice,
            'stokSparepart' => $stokSparepart,
            'stokAksesoris' => $stokAksesoris,
            'stokSoftware' => $stokSoftware,
            'totalServis' => $totalServis,
            'servisDone' => $servisDone,
            'servisCancelled' => $servisCancelled,
            'salesTrend' => $salesTrend,
            'profitTrend' => $profitTrend,
            'trendLabels' => $trendLabels,
            'lowUnitDevice' => $lowUnitDevice,
            'lowSparepart' => $lowSparepart,
            'lowAksesoris' => $lowAksesoris,
            'lowSoftware' => $lowSoftware,
            'totalSewa' => $totalSewa,
            'sewaAktif' => $sewaAktif,
            'sewaSelesai' => $sewaSelesai,
            'sewaTerlambat' => $sewaTerlambat,
            'omzetBulanIni' => $omzetBulanIni,
            'omzetBulanLalu' => $omzetBulanLalu,
            'labaBulanIni' => $labaBulanIni,
            'labaBulanLalu' => $labaBulanLalu,
            'omzetGrowth' => $omzetGrowth,
            'labaGrowth' => $labaGrowth,
        ]);
    }
}
