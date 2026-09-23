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
            'banners'                 => 'nullable|array|max:7',
            'banners.*.image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'banners.*.link'          => 'nullable|url|max:255',
            'banners.*.delete'        => 'nullable|boolean',
            'promo_product_links'     => 'nullable|array|max:3',
            'promo_product_links.*'   => 'nullable|url|max:255',
            'is_promo_active'         => 'nullable|boolean',
        ]);

        $setting = WebSetting::first();
        if (!$setting) {
            $setting = new WebSetting();
        }

        $promoBanners = $setting->promo_banners ?? [];
        // Migrate old single banner if promo_banners is empty
        if (empty($promoBanners) && $setting->promo_image_path) {
            $promoBanners[0] = [
                'image' => $setting->promo_image_path,
                'link'  => $setting->promo_link
            ];
            $setting->promo_image_path = null;
            $setting->promo_link = null;
        }

        $newBanners = [];

        if ($request->has('banners')) {
            foreach ($request->banners as $index => $bannerData) {
                $imagePath = $promoBanners[$index]['image'] ?? null;
                $link = $bannerData['link'] ?? null;

                // Handle delete
                if (isset($bannerData['delete']) && $bannerData['delete'] == 1) {
                    if ($imagePath) {
                        Storage::disk('public')->delete($imagePath);
                    }
                    continue; // Skip adding this banner
                }

                // Handle image upload
                if ($request->hasFile("banners.{$index}.image")) {
                    if ($imagePath) {
                        Storage::disk('public')->delete($imagePath);
                    }
                    $imagePath = $this->compressAndStore($request->file("banners.{$index}.image"), 'promos', 1200);
                }

                if ($imagePath) {
                    $newBanners[] = [
                        'image' => $imagePath,
                        'link'  => $link,
                    ];
                }
            }
        }

        // Re-index banners
        $setting->promo_banners = array_values($newBanners);

        // Simpan link produk promo (hanya yang tidak kosong)
        $productLinks = array_values(array_filter($request->input('promo_product_links', []), fn($v) => !empty(trim($v))));
        $setting->promo_product_links = $productLinks;

        $setting->is_promo_active = $request->has('is_promo_active');

        $setting->save();

        return redirect()->back()->with('success', 'Banner & Produk Promo berhasil diperbarui.');
    }
}
