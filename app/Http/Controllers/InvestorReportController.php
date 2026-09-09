<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\Product;
use App\Models\SaleDetail;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvestorReportExport;

class InvestorReportController extends Controller
{
    /**
     * Laporan konsolidasi investor — akses Admin.
     */
    public function index(Request $request)
    {
        $startDate   = $request->input('start_date');
        $endDate     = $request->input('end_date');
        $investorId  = $request->input('investor_id');

        // ===================================================
        // 1. ASET STOK AKTIF (KONSOLIDASI)
        // ===================================================
        $lktechAssetValue = (int) Product::lkTech()
            ->where('status', 'available')
            ->get()
            ->sum(fn($p) => ($p->stock ?? 1) * ($p->purchase_price ?? 0));

        $investorAssetQuery = Product::ownedByInvestor()->where('status', 'available');
        if ($investorId) {
            $investorAssetQuery->byInvestor((int)$investorId);
        }
        $investorAssetValue = (int) $investorAssetQuery->get()
            ->sum(fn($p) => ($p->stock ?? 1) * ($p->purchase_price ?? 0));

        $totalAssetValue = $lktechAssetValue + $investorAssetValue;

        // ===================================================
        // 2. PROFIT DARI PENJUALAN (dalam rentang tanggal)
        // ===================================================
        // Profit produk LKTech
        $lktechProfitQuery = SaleDetail::whereHas('product', fn($q) => $q->lkTech())
            ->whereHas('sale', fn($q) => $q->where('payment_status', 'success'));

        if ($startDate && $endDate) {
            $lktechProfitQuery->whereHas('sale', fn($q) => $q->whereBetween('created_at', [
                $startDate . ' 00:00:00', $endDate . ' 23:59:59'
            ]));
        } else {
            $lktechProfitQuery->whereHas('sale', fn($q) => $q
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
            );
        }
        $lktechGrossProfit = (int) $lktechProfitQuery->sum('profit');

        // ===================================================
        // 3. PER-INVESTOR BREAKDOWN
        // ===================================================
        $investorsQuery = Investor::where('is_active', true);
        if ($investorId) {
            $investorsQuery->where('id', $investorId);
        }
        $investors = $investorsQuery->orderBy('name')->get();

        $investorBreakdowns = $investors->map(function ($investor) use ($startDate, $endDate) {
            // Aset stok aktif
            $assetValue = $investor->totalAssetValue();

            // Profit dari penjualan
            $grossProfit    = $investor->totalGrossProfit($startDate, $endDate);
            $investorShare  = $investor->investorShareAmount($startDate, $endDate);
            $lktechShare    = $investor->lktechShareAmount($startDate, $endDate);

            // Detail transaksi per investor
            $detailQuery = SaleDetail::with(['sale.customer', 'product'])
                ->whereHas('product', fn($q) => $q->where('investor_id', $investor->id))
                ->whereHas('sale', fn($q) => $q->where('payment_status', 'success'));

            if ($startDate && $endDate) {
                $detailQuery->whereHas('sale', fn($q) => $q->whereBetween('created_at', [
                    $startDate . ' 00:00:00', $endDate . ' 23:59:59'
                ]));
            } else {
                $detailQuery->whereHas('sale', fn($q) => $q
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                );
            }

            $details = $detailQuery->orderBy('id', 'desc')->get()->map(function ($detail) use ($investor) {
                $profit         = $detail->profit ?? 0;
                $invShare       = (int) round($profit * ($investor->share_percentage / 100));
                $lkShare        = $profit - $invShare;
                return [
                    'id'             => $detail->id,
                    'sale_id'        => $detail->sale_id,
                    'invoice'        => '#INV-' . str_pad($detail->sale_id, 6, '0', STR_PAD_LEFT),
                    'customer'       => $detail->sale->customer->name ?? 'Umum',
                    'product'        => ($detail->product->brand ?? '') . ' ' . ($detail->product->model_series ?? ''),
                    'qty'            => $detail->quantity ?? 1,
                    'price'          => $detail->price_at_transaction ?? 0,
                    'purchase_price' => $detail->purchase_price ?? 0,
                    'profit'         => $profit,
                    'share_pct'      => $investor->share_percentage,
                    'investor_share' => $invShare,
                    'lktech_share'   => $lkShare,
                    'payout_status'  => $detail->investor_payout_status ?? 'pending',
                    'date'           => optional($detail->sale)->created_at,
                ];
            });

            return [
                'investor'       => $investor,
                'asset_value'    => $assetValue,
                'gross_profit'   => $grossProfit,
                'investor_share' => $investorShare,
                'lktech_share'   => $lktechShare,
                'details'        => $details,
            ];
        });

        // ===================================================
        // 4. TOTAL RINGKASAN
        // ===================================================
        $totalGrossProfit      = $investorBreakdowns->sum('gross_profit') + $lktechGrossProfit;
        $totalInvestorShare    = $investorBreakdowns->sum('investor_share');
        $totalLktechFromInvProd = $investorBreakdowns->sum('lktech_share');
        $totalLktechNetProfit  = $lktechGrossProfit + $totalLktechFromInvProd;

        $allInvestors = Investor::where('is_active', true)->orderBy('name')->get();

        return view('investors.report', compact(
            'investorBreakdowns',
            'allInvestors',
            'lktechAssetValue',
            'investorAssetValue',
            'totalAssetValue',
            'lktechGrossProfit',
            'totalGrossProfit',
            'totalInvestorShare',
            'totalLktechNetProfit',
            'startDate',
            'endDate',
            'investorId'
        ));
    }

    /**
     * Dashboard read-only untuk Investor yang login.
     */
    public function dashboard(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Cari investor yang terhubung dengan user ini via email
        $investor = Investor::where('email', $user->email)->first();

        if (!$investor) {
            return view('investors.dashboard', [
                'investor'       => null,
                'assetValue'     => 0,
                'grossProfit'    => 0,
                'investorShare'  => 0,
                'details'        => collect(),
                'profitTrend'    => [],
                'trendLabels'    => [],
                'totalInvestment'=> 0,
                'totalQty'       => 0,
                'soldQty'        => 0,
                'currentStockQty'=> 0,
                'totalPendingPayout' => 0,
                'totalPaidPayout'    => 0,
                'startDate'      => null,
                'endDate'        => null,
            ]);
        }

        // Aset aktif
        $assetValue    = $investor->totalAssetValue();
        $grossProfit   = $investor->totalGrossProfit($startDate, $endDate);
        $investorShare = $investor->investorShareAmount($startDate, $endDate);

        $totalInvestment = $investor->totalInvestmentValue();
        $totalQty = $investor->totalQty();
        $soldQty = $investor->soldQty();
        $currentStockQty = $investor->currentStockQty();

        // Trend profit 6 bulan terakhir
        $profitTrend = [];
        $trendLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $trendLabels[] = $month->translatedFormat('M Y');
            $start = $month->copy()->startOfMonth()->toDateString();
            $end   = $month->copy()->endOfMonth()->toDateString();
            $profitTrend[] = $investor->investorShareAmount($start, $end);
        }

        // Detail transaksi
        $detailQuery = SaleDetail::with(['sale.customer', 'product'])
            ->whereHas('product', fn($q) => $q->where('investor_id', $investor->id))
            ->whereHas('sale', fn($q) => $q->where('payment_status', 'success'));

        if ($startDate && $endDate) {
            $detailQuery->whereHas('sale', fn($q) => $q->whereBetween('created_at', [
                $startDate . ' 00:00:00', $endDate . ' 23:59:59'
            ]));
        }

        $detailsResults = $detailQuery->orderBy('id', 'desc')->get();

        $details = $detailsResults->map(function ($detail) use ($investor) {
                $profit   = $detail->profit ?? 0;
                $invShare = (int) round($profit * ($investor->share_percentage / 100));
                return [
                    'id'             => $detail->id,
                    'invoice'        => '#INV-' . str_pad($detail->sale_id, 6, '0', STR_PAD_LEFT),
                    'product'        => ($detail->product->brand ?? '') . ' ' . ($detail->product->model_series ?? ''),
                    'qty'            => $detail->quantity ?? 1,
                    'price'          => $detail->price_at_transaction ?? 0,
                    'purchase_price' => $detail->purchase_price ?? 0,
                    'profit'         => $profit,
                    'investor_share' => $invShare,
                    'payout_status'  => $detail->investor_payout_status ?? 'pending',
                    'date'           => optional($detail->sale)->created_at,
                ];
            });

        $totalPendingPayout = $details->where('payout_status', 'pending')->sum('investor_share');
        $totalPaidPayout    = $details->where('payout_status', 'paid')->sum('investor_share');

        // Produk aktif milik investor
        $activeProducts = $investor->activeProducts()->with('category')->get();

        return view('investors.dashboard', compact(
            'investor',
            'assetValue',
            'grossProfit',
            'investorShare',
            'details',
            'profitTrend',
            'trendLabels',
            'activeProducts',
            'totalInvestment',
            'totalQty',
            'soldQty',
            'currentStockQty',
            'totalPendingPayout',
            'totalPaidPayout',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Proses bulk payout untuk satu investor (Admin).
     */
    public function processBulkPayout(Request $request)
    {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'investor_id' => 'required|exists:investors,id',
            'payout_date' => 'required|date',
            'payout_account' => 'required|string|max:255',
            'payout_attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('payout_attachment')) {
            $attachmentPath = $request->file('payout_attachment')->store('payouts', 'public');
        }

        $details = SaleDetail::where(function($q) {
                $q->where('investor_payout_status', 'pending')
                  ->orWhereNull('investor_payout_status');
            })
            ->whereHas('sale', function($q) {
                $q->where('payment_status', 'success');
            })
            ->whereHas('product', function($q) use ($request) {
                $q->where('investor_id', $request->investor_id);
            })
            ->get();

        foreach ($details as $detail) {
            $detail->update([
                'investor_payout_status' => 'paid',
                'payout_date' => $request->payout_date,
                'payout_account' => $request->payout_account,
                'payout_attachment' => $attachmentPath
            ]);
        }

        return redirect()->back()->with('success', count($details) . ' transaksi berhasil dicairkan dan ditandai lunas.');
    }

    /**
     * Export laporan konsolidasi ke Excel (Admin).
     */
    public function export(Request $request)
    {
        $startDate   = $request->input('start_date');
        $endDate     = $request->input('end_date');
        $investorId  = $request->input('investor_id');

        $investorsQuery = Investor::where('is_active', true);
        if ($investorId) {
            $investorsQuery->where('id', $investorId);
        }
        $investors = $investorsQuery->orderBy('name')->get();

        $data = [];
        $investorName = 'Semua Investor';
        if ($investors->count() == 1) {
            $investorName = $investors->first()->name;
        }

        foreach ($investors as $investor) {
            $detailQuery = SaleDetail::with(['sale.customer', 'product'])
                ->whereHas('product', fn($q) => $q->where('investor_id', $investor->id))
                ->whereHas('sale', fn($q) => $q->where('payment_status', 'success'));

            if ($startDate && $endDate) {
                $detailQuery->whereHas('sale', fn($q) => $q->whereBetween('created_at', [
                    $startDate . ' 00:00:00', $endDate . ' 23:59:59'
                ]));
            } else {
                $detailQuery->whereHas('sale', fn($q) => $q
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                );
            }

            $details = $detailQuery->orderBy('id', 'desc')->get();
            foreach ($details as $detail) {
                $profit   = $detail->profit ?? 0;
                $invShare = (int) round($profit * ($investor->share_percentage / 100));
                $lkShare  = $profit - $invShare;
                
                $data[] = [
                    '#INV-' . str_pad($detail->sale_id, 6, '0', STR_PAD_LEFT),
                    ($detail->product->brand ?? '') . ' ' . ($detail->product->model_series ?? ''),
                    $detail->sale->customer->name ?? 'Umum',
                    $detail->quantity ?? 1,
                    $detail->price_at_transaction ?? 0,
                    $detail->purchase_price ?? 0,
                    $profit,
                    $investor->share_percentage . '%',
                    $invShare,
                    $lkShare,
                    optional($detail->sale)->created_at ? optional($detail->sale)->created_at->format('d/m/Y') : '-'
                ];
            }
        }

        $headers = ['Invoice', 'Produk', 'Pelanggan', 'Qty', 'Harga Jual', 'HPP', 'Profit Kotor', '% Bagi Hasil', 'Hak Investor', 'Bagian LKTech', 'Tanggal'];
        $title = 'Laporan Konsolidasi Investor: ' . $investorName;
        if ($startDate && $endDate) {
            $title .= " (" . \Carbon\Carbon::parse($startDate)->format('d/m/Y') . " - " . \Carbon\Carbon::parse($endDate)->format('d/m/Y') . ")";
        } else {
            $title .= " (" . now()->translatedFormat('F Y') . ")";
        }

        return Excel::download(new InvestorReportExport($data, $title, $headers), 'laporan_investor_' . date('Ymd_His') . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Export laporan dashboard ke Excel (Investor).
     */
    public function exportDashboard()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $investor = Investor::where('email', $user->email)->first();

        if (!$investor) {
            return redirect()->back()->with('error', 'Akun tidak terhubung dengan profil investor.');
        }

        $details = SaleDetail::with(['sale.customer', 'product'])
            ->whereHas('product', fn($q) => $q->where('investor_id', $investor->id))
            ->whereHas('sale', fn($q) => $q->where('payment_status', 'success'))
            ->orderBy('id', 'desc')
            ->get();

        $data = [];
        foreach ($details as $detail) {
            $profit   = $detail->profit ?? 0;
            $invShare = (int) round($profit * ($investor->share_percentage / 100));
            
            $data[] = [
                '#INV-' . str_pad($detail->sale_id, 6, '0', STR_PAD_LEFT),
                ($detail->product->brand ?? '') . ' ' . ($detail->product->model_series ?? ''),
                $detail->quantity ?? 1,
                $detail->price_at_transaction ?? 0,
                $profit,
                $invShare,
                optional($detail->sale)->created_at ? optional($detail->sale)->created_at->format('d/m/Y') : '-'
            ];
        }

        $headers = ['Invoice', 'Produk', 'Qty', 'Harga Jual', 'Profit Kotor', 'Hak Anda (' . number_format($investor->share_percentage, 1) . '%)', 'Tanggal'];
        $title = 'Riwayat Transaksi Investor: ' . $investor->name . ' (All Time)';

        return Excel::download(new InvestorReportExport($data, $title, $headers), 'riwayat_transaksi_' . $investor->name . '_' . date('Ymd_His') . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
