<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\Product;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvestorController extends Controller
{
    /**
     * Daftar semua investor beserta ringkasan aset.
     */
    public function index()
    {
        $investors = Investor::withCount('products')
            ->orderBy('name')
            ->get()
            ->map(function ($investor) {
                $investor->asset_value    = $investor->totalAssetValue();
                $investor->gross_profit   = $investor->totalGrossProfit();
                $investor->investor_share = $investor->investorShareAmount();
                return $investor;
            });

        $totalAsset       = $investors->sum('asset_value');
        $totalInvestorShare = $investors->sum('investor_share');

        return view('investors.index', compact('investors', 'totalAsset', 'totalInvestorShare'));
    }

    /**
     * Form tambah investor.
     */
    public function create()
    {
        return view('investors.create');
    }

    /**
     * Simpan investor baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'nullable|email|max:255',
            'phone'            => 'nullable|string|max:30',
            'share_percentage' => 'required|numeric|min:0|max:100',
            'notes'            => 'nullable|string',
            'is_active'        => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $investor = Investor::create($validated);

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'create',
            'module'      => 'Investor',
            'description' => 'Menambahkan investor baru: ' . $investor->name . ' (' . $investor->share_percentage . '%)',
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('investors.index')
            ->with('success', "Investor {$investor->name} berhasil ditambahkan.");
    }

    /**
     * Form edit investor.
     */
    public function edit(Investor $investor)
    {
        return view('investors.edit', compact('investor'));
    }

    /**
     * Update data investor.
     */
    public function update(Request $request, Investor $investor)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'nullable|email|max:255',
            'phone'            => 'nullable|string|max:30',
            'share_percentage' => 'required|numeric|min:0|max:100',
            'notes'            => 'nullable|string',
            'is_active'        => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $investor->update($validated);

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'update',
            'module'      => 'Investor',
            'description' => 'Memperbarui data investor: ' . $investor->name,
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('investors.index')
            ->with('success', "Data investor {$investor->name} berhasil diperbarui.");
    }

    /**
     * Hapus investor (hanya jika tidak ada produk terkait).
     */
    public function destroy(Investor $investor)
    {
        $productCount = $investor->products()->count();

        if ($productCount > 0) {
            return redirect()->route('investors.index')
                ->with('error', "Investor {$investor->name} tidak dapat dihapus karena masih memiliki {$productCount} produk terkait. Pindahkan atau ubah kepemilikan produk terlebih dahulu.");
        }

        $name = $investor->name;
        $investor->delete();

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'delete',
            'module'      => 'Investor',
            'description' => 'Menghapus investor: ' . $name,
            'ip_address'  => request()->ip(),
        ]);

        return redirect()->route('investors.index')
            ->with('success', "Investor {$name} berhasil dihapus.");
    }
}
