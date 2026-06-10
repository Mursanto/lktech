<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RakitPcPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RakitPcController extends Controller
{
    use \App\Traits\UploadsImage;
    public function index()
    {
        $packages = RakitPcPackage::orderBy('created_at', 'desc')->get();
        return view('admin.rakit-pc.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.rakit-pc.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'spesifikasi_singkat' => 'nullable|string',
            'harga_estimasi' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('foto')) {
            $path = $this->compressAndStore($request->file('foto'), 'rakit-pc');
            $validated['foto'] = $path;
        }

        RakitPcPackage::create($validated);

        return redirect()->route('rakit-pc-admin.index')->with('success', 'Paket Rakit PC berhasil ditambahkan.');
    }

    public function edit(RakitPcPackage $rakit_pc_admin)
    {
        // the parameter name matches the resource name (rakit-pc-admin -> $rakit_pc_admin)
        $package = $rakit_pc_admin;
        return view('admin.rakit-pc.edit', compact('package'));
    }

    public function update(Request $request, RakitPcPackage $rakit_pc_admin)
    {
        $package = $rakit_pc_admin;
        
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'spesifikasi_singkat' => 'nullable|string',
            'harga_estimasi' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('foto')) {
            if ($package->foto && Storage::disk('public')->exists($package->foto)) {
                Storage::disk('public')->delete($package->foto);
            }
            $path = $this->compressAndStore($request->file('foto'), 'rakit-pc');
            $validated['foto'] = $path;
        }

        $package->update($validated);

        return redirect()->route('rakit-pc-admin.index')->with('success', 'Paket Rakit PC berhasil diperbarui.');
    }

    public function destroy(RakitPcPackage $rakit_pc_admin)
    {
        $package = $rakit_pc_admin;

        if ($package->foto && Storage::disk('public')->exists($package->foto)) {
            Storage::disk('public')->delete($package->foto);
        }

        $package->delete();

        return redirect()->route('rakit-pc-admin.index')->with('success', 'Paket Rakit PC berhasil dihapus.');
    }
}
