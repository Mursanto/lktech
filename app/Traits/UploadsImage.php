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
     *
     * @param UploadedFile $file
     * @param string $directory Path to store (e.g. 'public/catalog', 'blogs')
     * @param int $maxWidth
     * @param int $quality
     * @return string Stored file path
     */
    public function compressAndStore(UploadedFile $file, $directory, $maxWidth = 1000, $quality = 80)
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);

        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        $filename = uniqid() . '.webp';
        $encoded = $image->toWebp($quality);

        // Remove trailing slash if exists
        $directory = rtrim($directory, '/');
        $path = $directory . '/' . $filename;

        // In Laravel, Storage::disk('public')->put() expects a path relative to the disk's root.
        // However, some existing code uses $file->store('blogs', 'public') which uses the 'public' disk.
        // If $directory already includes 'public/', we might want to store using default disk or public disk.
        // Let's standardise: if the directory already starts with 'public/', we'll use the default disk 
        // (which is usually local and 'public/' goes to storage/app/public).
        // If it doesn't, we'll explicitly use the 'public' disk.
        
        if (str_starts_with($directory, 'public/')) {
            Storage::put($path, (string) $encoded);
        } else {
            Storage::disk('public')->put($path, (string) $encoded);
        }

        return $path;
    }
}
