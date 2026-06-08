<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JasaWebsite;
use Illuminate\Http\Request;

class JasaWebsiteController extends Controller
{
    public function index()
    {
        $packages = JasaWebsite::orderBy('harga_mulai', 'asc')->get();
        return view('admin.jasa-website.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.jasa-website.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga_mulai' => 'required|numeric|min:0',
            'fitur_list' => 'nullable|string',
            'deskripsi_singkat' => 'nullable|string',
            'badge' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        JasaWebsite::create($validated);

        return redirect()->route('jasa-website-admin.index')->with('success', 'Paket Jasa Website berhasil ditambahkan.');
    }

    public function edit(JasaWebsite $jasa_website_admin)
    {
        $package = $jasa_website_admin;
        return view('admin.jasa-website.edit', compact('package'));
    }

    public function update(Request $request, JasaWebsite $jasa_website_admin)
    {
        $package = $jasa_website_admin;
        
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga_mulai' => 'required|numeric|min:0',
            'fitur_list' => 'nullable|string',
            'deskripsi_singkat' => 'nullable|string',
            'badge' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $package->update($validated);

        return redirect()->route('jasa-website-admin.index')->with('success', 'Paket Jasa Website berhasil diperbarui.');
    }

    public function destroy(JasaWebsite $jasa_website_admin)
    {
        $package = $jasa_website_admin;

        $package->delete();

        return redirect()->route('jasa-website-admin.index')->with('success', 'Paket Jasa Website berhasil dihapus.');
    }
}
