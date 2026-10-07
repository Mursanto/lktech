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

                $thumb600Path = preg_replace('/\.(webp|jpe?g|jfif|png)$/i', '_thumb.webp', $filePath);
                $thumb300Path = preg_replace('/\.(webp|jpe?g|jfif|png)$/i', '_300.webp', $filePath);

                if (!$force && $disk->exists($thumb600Path) && $disk->exists($thumb300Path)) {
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

                    // 1. Skala varian 600px
                    if (!$disk->exists($thumb600Path) || $force) {
                        $img600 = clone $image;
                        if ($img600->width() > 600) {
                            $img600->scaleDown(width: 600);
                        }
                        $encoded600 = method_exists($img600, 'toWebp')
                            ? $img600->toWebp(80)
                            : $img600->encode(new \Intervention\Image\Encoders\WebpEncoder(80));
                        $disk->put($thumb600Path, (string) $encoded600);
                        $created++;
                    }

                    // 2. Skala varian 300px
                    if (!$disk->exists($thumb300Path) || $force) {
                        $img300 = clone $image;
                        if ($img300->width() > 300) {
                            $img300->scaleDown(width: 300);
                        }
                        $encoded300 = method_exists($img300, 'toWebp')
                            ? $img300->toWebp(80)
                            : $img300->encode(new \Intervention\Image\Encoders\WebpEncoder(80));
                        $disk->put($thumb300Path, (string) $encoded300);
                        $created++;
                    }

                    $this->line("<info>[OK]</info> Diproses: {$filePath}");

                    unset($image);
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
