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
            $q->where('name', 'LIKE', '%Device%')->orWhere('name', 'LIKE', '%Laptop%')->orWhere('name', 'LIKE', '%PC%'); 
        })->sum('stock');

        $stokSparepart = \App\Models\Product::where('status', 'available')->whereHas('category', function($q) { 
            $q->where('name', 'LIKE', '%Sparepart%')->orWhere('name', 'LIKE', '%Part%'); 
        })->sum('stock');

        $stokAksesoris = \App\Models\Product::where('status', 'available')->whereHas('category', function($q) { 
            $q->where('name', 'LIKE', '%Aksesoris%')->orWhere('name', 'LIKE', '%Aksesori%'); 
        })->sum('stock');

        $stokSoftware = \App\Models\Product::where('status', 'available')->whereHas('category', function($q) { 
            $q->where('name', 'LIKE', '%Software%'); 
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
            $salesTrend[] = \App\Models\Sale::whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->sum('total_amount');
            $profitTrend[] = \App\Models\Sale::whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->sum('profit_amount');
        }

        // Data Stok Unit Device Menipis (Max 5)
        $lowUnitDevice = \App\Models\Product::with('category')->where('status', 'available')
            ->whereHas('category', function($q) {
                $q->where('name', 'Unit Device')->orWhereHas('parent', function($q2) { $q2->where('name', 'Unit Device'); });
            })->where('stock', '>', 0)->orderBy('stock', 'asc')->limit(5)->get();

        // Data Stok Sparepart Menipis (Max 5)
        $lowSparepart = \App\Models\Product::with('category')->where('status', 'available')
            ->whereHas('category', function($q) {
                $q->where('name', 'Sparepart / Komponen')->orWhereHas('parent', function($q2) { $q2->where('name', 'Sparepart / Komponen'); });
            })->where('stock', '>', 0)->orderBy('stock', 'asc')->limit(5)->get();

        // Data Stok Aksesoris Menipis (Max 3)
        $lowAksesoris = \App\Models\Product::with('category')->where('status', 'available')
            ->whereHas('category', function($q) {
                $q->where('name', 'Aksesoris')->orWhereHas('parent', function($q2) { $q2->where('name', 'Aksesoris'); });
            })->where('stock', '>', 0)->orderBy('stock', 'asc')->limit(3)->get();

        // Data Stok Software Menipis (Max 3)
        $lowSoftware = \App\Models\Product::with('category')->where('status', 'available')
            ->whereHas('category', function($q) {
                $q->where('name', 'Software / Digital')->orWhereHas('parent', function($q2) { $q2->where('name', 'Software / Digital'); });
            })->where('stock', '>', 0)->orderBy('stock', 'asc')->limit(3)->get();



        // 4. Data Sewa Laptop
        $totalSewa = 0;
        $sewaAktif = 0;
        $sewaSelesai = 0;
        $sewaTerlambat = 0;
        try {
            $totalSewa = \App\Models\Rental::count();
            $sewaAktif = \App\Models\Rental::where('status', 'active')->count();
            $sewaSelesai = \App\Models\Rental::where('status', 'completed')->count();
            $sewaTerlambat = \App\Models\Rental::where('status', 'late')->count();
        } catch (\Exception $e) {
            // Rental model might not exist or table not created
        }

        // 5. Perbandingan Omzet & Laba (Bulan Ini vs Bulan Lalu)
        $omzetBulanIni = \App\Models\Sale::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total_amount');
        $omzetBulanLalu = \App\Models\Sale::whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->sum('total_amount');
        
        $labaBulanIni = \App\Models\Sale::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('profit_amount');
        $labaBulanLalu = \App\Models\Sale::whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->sum('profit_amount');

        $visitorCount = \App\Models\CatalogVisitor::whereMonth('visited_at', now()->month)
                                                  ->whereYear('visited_at', now()->year)
                                                  ->count();

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
        ]);
    }
}
