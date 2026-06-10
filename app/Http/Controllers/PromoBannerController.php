<?php

namespace App\Http\Controllers;

use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromoBannerController extends Controller
{
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
            $file = $request->file('promo_image');
            $filename = 'promo_' . time() . '.webp';
            $dirPath = storage_path('app/public/promos');
            $path = $dirPath . '/' . $filename;
            
            // Ensure directory exists
            if (!file_exists($dirPath)) {
                mkdir($dirPath, 0755, true);
            }

            // Native PHP GD Compression
            $info = getimagesize($file->getPathname());
            if ($info !== false) {
                $width = $info[0];
                $height = $info[1];
                $mime = $info['mime'];

                $image = null;
                switch ($mime) {
                    case 'image/jpeg':
                        $image = @imagecreatefromjpeg($file->getPathname());
                        break;
                    case 'image/png':
                        $image = @imagecreatefrompng($file->getPathname());
                        break;
                    case 'image/webp':
                        $image = @imagecreatefromwebp($file->getPathname());
                        break;
                }

                if ($image) {
                    $maxWidth = 1200;
                    if ($width > $maxWidth) {
                        $newWidth = $maxWidth;
                        $newHeight = floor($height * ($maxWidth / $width));
                        $newImage = imagecreatetruecolor($newWidth, $newHeight);
                        
                        // Handle transparency
                        imagealphablending($newImage, false);
                        imagesavealpha($newImage, true);
                        $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                        imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);

                        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                        imagedestroy($image);
                        $image = $newImage;
                    }

                    // Delete old image if exists
                    if ($setting->promo_image_path) {
                        Storage::disk('public')->delete($setting->promo_image_path);
                    }

                    // Convert and save as WebP
                    imagewebp($image, $path, 80); // 80% quality
                    imagedestroy($image);

                    $setting->promo_image_path = 'promos/' . $filename;
                } else {
                    return back()->with('error', 'Gagal memproses gambar. Format tidak didukung.');
                }
            } else {
                return back()->with('error', 'File bukan gambar yang valid.');
            }
        }

        $setting->save();

        return redirect()->back()->with('success', 'Banner Promo berhasil diperbarui.');
    }
}
