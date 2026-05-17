<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicCatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('stock', '>', 0);

        if (!$request->has('search') && !$request->has('all')) {
            $query->whereHas('category', function($q) {
                $q->where('name', 'like', '%laptop%')
                  ->orWhere('name', 'like', '%ultrabook%')
                  ->orWhere('name', 'like', '%komputer%')
                  ->orWhere('name', 'like', '%pc%');
            });
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                  ->orWhere('model_series', 'like', "%{$search}%")
                  ->orWhere('processor', 'like', "%{$search}%");
            });
        }
        $products = $query->paginate(6);

        $products->getCollection()->transform(function ($product) {
            if ($product->image_path) {
                $product->display_image = Storage::url($product->image_path);
            } else {
                $searchQuery = urlencode($product->brand . ' ' . $product->model_series . ' laptop');
                $product->display_image = "https://source.unsplash.com/400x400/?{$searchQuery}";
            }
            return $product;
        });

        return view('welcome', compact('products'));
    }

    public function show(Product $product)
    {
        // Setup main image
        if ($product->image_path) {
            $product->display_image = Storage::url($product->image_path);
        } else {
            $searchQuery = urlencode($product->brand . ' ' . $product->model_series . ' laptop');
            $product->display_image = "https://source.unsplash.com/600x600/?{$searchQuery}";
        }

        // Setup gallery images
        $gallery = [];
        $gallery[] = $product->display_image; // Always include main image first
        if ($product->gallery_images && is_array($product->gallery_images)) {
            foreach ($product->gallery_images as $path) {
                $gallery[] = Storage::url($path);
            }
        }
        $product->all_images = $gallery;

        return view('katalog.show', compact('product'));
    }
}
