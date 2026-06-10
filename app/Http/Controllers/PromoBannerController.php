<?php

namespace App\Http\Controllers;

use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromoBannerController extends Controller
{
    use \App\Traits\UploadsImage;
    public function edit()
    {
        $setting = WebSetting::firstOrCreate(
            ['id' => 1],
            ['nama_toko' => 'LKTech TN SEREAL']
        );
        return view('promo.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'promo_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'promo_link' => 'nullable|url|max:255',
        ]);

        $setting = WebSetting::first();
        if (!$setting) {
            $setting = new WebSetting();
        }

        $setting->promo_link = $request->promo_link;

        if ($request->hasFile('promo_image')) {
            // Delete old image if exists
            if ($setting->promo_image_path) {
                Storage::disk('public')->delete($setting->promo_image_path);
            }

            $setting->promo_image_path = $this->compressAndStore($request->file('promo_image'), 'promos', 1200);
        }

        $setting->save();

        return redirect()->back()->with('success', 'Banner Promo berhasil diperbarui.');
    }
}
