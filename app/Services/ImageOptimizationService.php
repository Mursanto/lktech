<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageOptimizationService
{
    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Konversi & kompres gambar yang di-upload ke format WebP (kualitas 75-80%)
     * serta otomatis buat 3 varian responsif:
     * - Desktop: max-width 1200px
     * - Mobile: max-width 600px (_600.webp / _thumb.webp)
     * - Thumbnail: max-width 300px (_300.webp)
     *
     * @param UploadedFile|string $file
     * @param string $directory (contoh: 'public/catalog', 'banners')
     * @param int $quality (default 80%)
     * @return array paths of stored files
     */
    public function convertAndStore($file, string $directory = 'public/catalog', int $quality = 80): array
    {
        $directory = rtrim($directory, '/');
        $baseId = uniqid('img_') . '_' . time();
        $disk = str_starts_with($directory, 'public/') ? Storage::disk('local') : Storage::disk('public');
        
        $sourcePath = $file instanceof UploadedFile ? $file->getPathname() : $file;

        try {
            $image = method_exists($this->manager, 'read')
                ? $this->manager->read($sourcePath)
                : $this->manager->decode($sourcePath);

            // 1. Varian Desktop (max-width 1200px)
            $desktopImage = clone $image;
            if ($desktopImage->width() > 1200) {
                $desktopImage->scaleDown(width: 1200);
            }
            $desktopEncoded = method_exists($desktopImage, 'toWebp')
                ? $desktopImage->toWebp($quality)
                : $desktopImage->encode(new \Intervention\Image\Encoders\WebpEncoder($quality));
            $desktopFilename = $baseId . '.webp';
            $desktopPath = $directory . '/' . $desktopFilename;
            $disk->put($desktopPath, (string) $desktopEncoded);

            // 2. Varian Mobile (max-width 600px)
            $mobileImage = clone $image;
            if ($mobileImage->width() > 600) {
                $mobileImage->scaleDown(width: 600);
            }
            $mobileEncoded = method_exists($mobileImage, 'toWebp')
                ? $mobileImage->toWebp($quality)
                : $mobileImage->encode(new \Intervention\Image\Encoders\WebpEncoder($quality));
            $mobileFilename = $baseId . '_600.webp';
            $mobilePath = $directory . '/' . $mobileFilename;
            $disk->put($mobilePath, (string) $mobileEncoded);

            // Juga simpan alias _thumb.webp untuk backward-compatibility
            $legacyThumbPath = $directory . '/' . $baseId . '_thumb.webp';
            $disk->put($legacyThumbPath, (string) $mobileEncoded);

            // 3. Varian Thumbnail (max-width 300px)
            $thumbImage = clone $image;
            if ($thumbImage->width() > 300) {
                $thumbImage->scaleDown(width: 300);
            }
            $thumbEncoded = method_exists($thumbImage, 'toWebp')
                ? $thumbImage->toWebp($quality)
                : $thumbImage->encode(new \Intervention\Image\Encoders\WebpEncoder($quality));
            $thumbFilename = $baseId . '_300.webp';
            $thumbPath = $directory . '/' . $thumbFilename;
            $disk->put($thumbPath, (string) $thumbEncoded);

            return [
                'main' => $desktopPath,
                'desktop' => $desktopPath,
                'mobile' => $mobilePath,
                'thumbnail' => $thumbPath,
            ];
        } catch (\Throwable $e) {
            Log::error('ImageOptimizationService error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Resolve responsif URLs untuk template Blade (300w, 600w, 1200w)
     *
     * @param string|null $imagePath
     * @return array
     */
    public static function resolveResponsiveVariants(?string $imagePath): array
    {
        $fallback = asset('images/LKtech-fallback.webp');
        if (!$imagePath) {
            return [
                'thumb_300' => $fallback,
                'mobile_600' => $fallback,
                'desktop_1200' => $fallback,
                'srcset' => "{$fallback} 300w, {$fallback} 600w, {$fallback} 1200w",
                'sizes' => "(max-width: 640px) 45vw, (max-width: 1024px) 30vw, 220px",
            ];
        }

        $cleanPath = preg_replace('/^public\//', '', $imagePath);
        $disk = Storage::disk('public');

        // Path dasar tanpa ekstensi atau suffix thumb
        $baseWithoutExt = preg_replace('/(_(300|600|thumb))?\.(jpe?g|jfif|png|webp)$/i', '', $cleanPath);

        // 1. Cek Varian 300px
        $path300 = $baseWithoutExt . '_300.webp';
        $url300 = ($disk->exists($path300) || file_exists(public_path('storage/' . $path300)))
            ? asset('storage/' . $path300)
            : null;

        // 2. Cek Varian 600px (atau legacy _thumb.webp)
        $path600 = $baseWithoutExt . '_600.webp';
        $pathThumb = $baseWithoutExt . '_thumb.webp';
        if ($disk->exists($path600) || file_exists(public_path('storage/' . $path600))) {
            $url600 = asset('storage/' . $path600);
        } elseif ($disk->exists($pathThumb) || file_exists(public_path('storage/' . $pathThumb))) {
            $url600 = asset('storage/' . $pathThumb);
        } else {
            $url600 = null;
        }

        // 3. Cek Varian Desktop (1200px / .webp asli)
        $path1200 = $baseWithoutExt . '.webp';
        if ($disk->exists($path1200) || file_exists(public_path('storage/' . $path1200))) {
            $url1200 = asset('storage/' . $path1200);
        } elseif ($disk->exists($cleanPath) || file_exists(public_path('storage/' . $cleanPath))) {
            $url1200 = asset('storage/' . $cleanPath);
        } else {
            $url1200 = $fallback;
        }

        // Fallbacks jika varian belum dibuat
        $url600 = $url600 ?: $url1200;
        $url300 = $url300 ?: $url600;

        return [
            'thumb_300' => $url300,
            'mobile_600' => $url600,
            'desktop_1200' => $url1200,
            'srcset' => "{$url300} 300w, {$url600} 600w, {$url1200} 1200w",
            'sizes' => "(max-width: 640px) 45vw, (max-width: 1024px) 30vw, 220px",
        ];
    }
}
