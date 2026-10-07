<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

trait UploadsImage
{
    /**
     * Compress an uploaded image, convert to WebP, and store it.
     * Otomatis menyimpan versi thumbnail untuk catalog produk (format WebP, kualitas 80%).
     *
     * @param UploadedFile $file
     * @param string $directory Path to store (e.g. 'public/catalog', 'blogs')
     * @param int $maxWidth Max width main image (default 800px)
     * @param int $quality Quality compression (default 80%)
     * @param bool|null $createThumbnail Generate thumbnail variant (default true for catalog)
     * @param int $thumbMaxWidth Max width thumbnail (default 600px)
     * @return string Stored file path
     */
    public function compressAndStore(
        UploadedFile $file,
        $directory,
        $maxWidth = 800,
        $quality = 80,
        $createThumbnail = null,
        $thumbMaxWidth = 600
    ) {
        $manager = new ImageManager(new Driver());
        
        // Kompatibilitas untuk versi Intervention Image yang berbeda
        if (method_exists($manager, 'read')) {
            $image = $manager->read($file->getPathname());
        } elseif (method_exists($manager, 'decodePath')) {
            $image = $manager->decodePath($file->getPathname());
        } else {
            $image = $manager->decode($file->getPathname());
        }

        // Skala maksimal gambar utama (default 800px)
        if ($image->width() > $maxWidth) {
            $image->scaleDown(width: $maxWidth);
        }

        $baseId = uniqid('img_') . '_' . time();
        $filename = $baseId . '.webp';
        
        if (method_exists($image, 'toWebp')) {
            $encoded = $image->toWebp($quality);
        } else {
            $encoded = $image->encode(new \Intervention\Image\Encoders\WebpEncoder($quality));
        }

        // Remove trailing slash if exists
        $directory = rtrim($directory, '/');
        $path = $directory . '/' . $filename;

        if (str_starts_with($directory, 'public/')) {
            Storage::put($path, (string) $encoded);
        } else {
            Storage::disk('public')->put($path, (string) $encoded);
        }

        // Generate thumbnail jika direktori katalog atau jika createThumbnail diaktifkan
        $shouldCreateThumb = ($createThumbnail === true) || ($createThumbnail === null && str_contains($directory, 'catalog'));
        if ($shouldCreateThumb) {
            try {
                if (method_exists($manager, 'read')) {
                    $thumbImage = $manager->read($file->getPathname());
                } elseif (method_exists($manager, 'decodePath')) {
                    $thumbImage = $manager->decodePath($file->getPathname());
                } else {
                    $thumbImage = $manager->decode($file->getPathname());
                }

                if ($thumbImage->width() > $thumbMaxWidth) {
                    $thumbImage->scaleDown(width: $thumbMaxWidth);
                }

                $thumbFilename = $baseId . '_thumb.webp';
                if (method_exists($thumbImage, 'toWebp')) {
                    $encodedThumb = $thumbImage->toWebp($quality);
                } else {
                    $encodedThumb = $thumbImage->encode(new \Intervention\Image\Encoders\WebpEncoder($quality));
                }

                $thumbPath = $directory . '/' . $thumbFilename;
                if (str_starts_with($directory, 'public/')) {
                    Storage::put($thumbPath, (string) $encodedThumb);
                } else {
                    Storage::disk('public')->put($thumbPath, (string) $encodedThumb);
                }

                // Varian 300px untuk Mobile LCP & grid hemat bandwidth
                if ($thumbImage->width() > 300) {
                    $thumbImage->scaleDown(width: 300);
                }
                $thumb300Filename = $baseId . '_300.webp';
                $encoded300 = method_exists($thumbImage, 'toWebp')
                    ? $thumbImage->toWebp($quality)
                    : $thumbImage->encode(new \Intervention\Image\Encoders\WebpEncoder($quality));
                $thumb300Path = $directory . '/' . $thumb300Filename;
                if (str_starts_with($directory, 'public/')) {
                    Storage::put($thumb300Path, (string) $encoded300);
                } else {
                    Storage::disk('public')->put($thumb300Path, (string) $encoded300);
                }

                unset($thumbImage);
                unset($encodedThumb);
                unset($encoded300);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Gagal membuat thumbnail: ' . $e->getMessage());
            }
        }

        unset($image);
        unset($encoded);
        if (function_exists('gc_collect_cycles')) {
            gc_collect_cycles();
        }

        return $path;
    }

    /**
     * Hapus gambar beserta file thumbnail terkait jika ada.
     */
    public function deleteImageWithThumbnail(?string $path)
    {
        if (!$path) return;

        // 1. Storage default
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
        $thumbPath = preg_replace('/\.(jpe?g|jfif|png|webp)$/i', '_thumb.webp', $path);
        if ($thumbPath !== $path && Storage::exists($thumbPath)) {
            Storage::delete($thumbPath);
        }

        // 2. Storage disk public
        $cleanPath = preg_replace('/^public\//', '', $path);
        if (Storage::disk('public')->exists($cleanPath)) {
            Storage::disk('public')->delete($cleanPath);
        }
        $cleanThumb = preg_replace('/\.(jpe?g|jfif|png|webp)$/i', '_thumb.webp', $cleanPath);
        if ($cleanThumb !== $cleanPath && Storage::disk('public')->exists($cleanThumb)) {
            Storage::disk('public')->delete($cleanThumb);
        }
    }
}
