<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WifiVoucher;
use Illuminate\Http\Request;

class WifiVoucherController extends Controller
{
    public function index()
    {
        $packages = WifiVoucher::orderBy('harga', 'asc')->get();
        return view('admin.wifi-voucher.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.wifi-voucher.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'fitur_list' => 'nullable|string',
            'deskripsi_singkat' => 'nullable|string',
            'badge' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        WifiVoucher::create($validated);

        return redirect()->route('wifi-voucher-admin.index')->with('success', 'Paket WiFi Voucher berhasil ditambahkan.');
    }

    public function edit(WifiVoucher $wifi_voucher_admin)
    {
        $package = $wifi_voucher_admin;
        return view('admin.wifi-voucher.edit', compact('package'));
    }

    public function update(Request $request, WifiVoucher $wifi_voucher_admin)
    {
        $package = $wifi_voucher_admin;
        
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'fitur_list' => 'nullable|string',
            'deskripsi_singkat' => 'nullable|string',
            'badge' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $package->update($validated);

        return redirect()->route('wifi-voucher-admin.index')->with('success', 'Paket WiFi Voucher berhasil diperbarui.');
    }

    public function destroy(WifiVoucher $wifi_voucher_admin)
    {
        $package = $wifi_voucher_admin;

        $package->delete();

        return redirect()->route('wifi-voucher-admin.index')->with('success', 'Paket WiFi Voucher berhasil dihapus.');
    }
}
