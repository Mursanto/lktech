<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GenerateImageThumbnails extends Command
{
    protected $signature = 'images:generate-thumbnails {--force : Timpa thumbnail yang sudah ada}';
    protected $description = 'Generate WebP thumbnails (max 600px, quality 80%) untuk semua gambar katalog produk';

    public function handle()
    {
        $this->info("Memulai pembuatan thumbnail responsif produk (WebP, max-width 600px, 80% quality)...");

        $disk = Storage::disk('public');
        $manager = new ImageManager(new Driver());
        $force = $this->option('force');

        // Direktori yang dicek
        $directories = ['catalog', 'catalog/gallery'];
        $created = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($directories as $dir) {
            $files = $disk->files($dir);
            $this->info("Memproses direktori {$dir} (" . count($files) . " file)...");

            foreach ($files as $filePath) {
                // Jangan proses thumbnail itu sendiri atau file non-gambar
                if (str_ends_with(strtolower($filePath), '_thumb.webp')) {
                    continue;
                }

                if (!preg_match('/\.(webp|jpe?g|jfif|png)$/i', $filePath)) {
                    continue;
                }

                $thumbPath = preg_replace('/\.(webp|jpe?g|jfif|png)$/i', '_thumb.webp', $filePath);

                if (!$force && $disk->exists($thumbPath)) {
                    $skipped++;
                    continue;
                }

                try {
                    $fullPath = $disk->path($filePath);
                    if (method_exists($manager, 'read')) {
                        $image = $manager->read($fullPath);
                    } else {
                        $image = $manager->decode($fullPath);
                    }

                    // Skala maksimal lebar 600px
                    if ($image->width() > 600) {
                        $image->scaleDown(width: 600);
                    }

                    if (method_exists($image, 'toWebp')) {
                        $encoded = $image->toWebp(80);
                    } else {
                        $encoded = $image->encode(new \Intervention\Image\Encoders\WebpEncoder(80));
                    }

                    $disk->put($thumbPath, (string) $encoded);
                    $created++;
                    $this->line("<info>[OK]</info> Dibuat: {$thumbPath} (" . round(strlen((string) $encoded) / 1024, 1) . " KB)");

                    unset($image);
                    unset($encoded);
                } catch (\Exception $e) {
                    $failed++;
                    $this->error("[FAIL] Gagal memproses {$filePath}: " . $e->getMessage());
                }
            }
        }

        $this->info("--------------------------------------------------");
        $this->info("Selesai! Berhasil dibuat: {$created}, Sudah ada: {$skipped}, Gagal: {$failed}");
        return 0;
    }
}
