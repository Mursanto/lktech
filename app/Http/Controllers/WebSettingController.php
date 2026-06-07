<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\WebSetting;

class WebSettingController extends Controller
{
    public function edit()
    {
        $setting = WebSetting::firstOrCreate(
            ['id' => 1],
            ['nama_toko' => 'LKTech TN SEREAL']
        );
        return view('settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            // other fields are optional
        ]);

        $setting = WebSetting::first();
        if (!$setting) {
            $setting = new WebSetting();
        }

        $setting->fill($request->except(['_token', '_method']));
        $setting->save();

        return redirect()->back()->with('success', 'Pengaturan Web berhasil diperbarui.');
    }
}
