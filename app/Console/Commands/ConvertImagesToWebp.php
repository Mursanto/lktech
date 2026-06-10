<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Post;
use App\Models\WebSetting;
use App\Models\RakitPcPackage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ConvertImagesToWebp extends Command
{
    protected $signature = 'images:convert-webp';
    protected $description = 'Batch convert all existing legacy images to WebP format';

    public function handle()
    {
        $this->info("Starting global image conversion to WebP...");

        $manager = new ImageManager(new Driver());
        $disk = Storage::disk('public');

        // Example: Convert Product Main Images
        $products = Product::whereNotNull('image_path')->get();
        $this->info("Processing Product Main Images ({$products->count()})...");
        foreach ($products as $product) {
            if (!str_ends_with(strtolower($product->image_path), '.webp') && $disk->exists($product->image_path)) {
                $fileContent = $disk->get($product->image_path);
                try {
                    $image = $manager->read($fileContent);
                    $encoded = $image->toWebp(80);
                    
                    $newPath = preg_replace('/\.[^.]+$/', '.webp', $product->image_path);
                    $disk->put($newPath, (string) $encoded);
                    
                    $oldPath = $product->image_path;
                    $product->update(['image_path' => $newPath]);
                    $disk->delete($oldPath);
                    $this->line("Converted: {$newPath}");
                } catch (\Exception $e) {
                    $this->error("Failed to convert {$product->image_path}: " . $e->getMessage());
                }
            }
        }

        // NOTE: The same logic can be replicated for:
        // - Product Gallery Images ($product->gallery_images array)
        // - Posts ($post->thumbnail)
        // - Promo Banners ($setting->promo_image_path)
        // - Rakit PC ($package->foto)

        $this->info("Conversion task completed! Please check your storage directory.");
    }
}
