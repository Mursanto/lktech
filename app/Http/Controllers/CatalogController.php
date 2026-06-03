<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::with('category')
                    ->where('stock', '>', 0)
                    ->where('status', '!=', 'sold');

        if ($request->has('category_id') && $request->category_id != '') {
            $categoryId = $request->category_id;
            $category = \App\Models\Category::with('children')->find($categoryId);
            if ($category) {
                $categoryIds = $category->children->pluck('id')->push($category->id)->toArray();
                $query->whereIn('category_id', $categoryIds);
            }
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('brand', 'LIKE', "%{$search}%")
                  ->orWhere('model_series', 'LIKE', "%{$search}%")
                  ->orWhere('processor', 'LIKE', "%{$search}%")
                  ->orWhereHas('category', function($cat) use ($search) {
                      $cat->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $products = $query->latest()->paginate(12)->appends($request->all());
        $categories = \App\Models\Category::with('children')->whereNull('parent_id')->get();

        // Map through products to assign image logic
        $products->getCollection()->transform(function ($product) {
            if ($product->image_path) {
                $product->display_image = Storage::url($product->image_path);
            } else {
                // Auto-fetch Fallback: Unsplash using product brand and model
                $searchQuery = urlencode($product->brand . ' ' . $product->model_series . ' laptop');
                $product->display_image = "https://source.unsplash.com/400x400/?{$searchQuery}";
            }
            return $product;
        });

        return view('catalog.index', compact('products', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $catalog)
    {
        $product = $catalog; // Route model binding maps it to 'catalog'
        return view('catalog.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $catalog)
    {
        $product = $catalog;

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_path && Storage::exists($product->image_path)) {
                Storage::delete($product->image_path);
            }

            $file = $request->file('image');
            $filename = time() . '_main_' . Str::slug($product->brand . '-' . $product->model_series) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/catalog', $filename);
            $product->image_path = $path;
        }

        $galleryPaths = is_array($product->gallery_images) ? $product->gallery_images : [];
        $galleryUpdated = false;

        if ($request->has('delete_gallery')) {
            foreach ($request->delete_gallery as $delPath) {
                if (in_array($delPath, $galleryPaths)) {
                    if (Storage::exists($delPath)) Storage::delete($delPath);
                    $galleryPaths = array_diff($galleryPaths, [$delPath]);
                    $galleryUpdated = true;
                }
            }
            $galleryPaths = array_values($galleryPaths); // Re-index array
        }

        if ($request->hasFile('gallery_images')) {
            $newFiles = $request->file('gallery_images');
            if ((count($galleryPaths) + count($newFiles)) > 9) {
                return redirect()->back()->withErrors(['gallery_images' => 'Total maksimal foto galeri adalah 9 lembar.'])->withInput();
            }
            
            foreach ($newFiles as $index => $file) {
                if (count($galleryPaths) >= 9) break; // Limit to 9 gallery images
                
                $filename = time() . '_gallery_' . uniqid() . '_' . Str::slug($product->brand . '-' . $product->model_series) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('public/catalog/gallery', $filename);
                $galleryPaths[] = $path;
                $galleryUpdated = true;
            }
        }
        
        if ($galleryUpdated) {
            $product->gallery_images = $galleryPaths;
        }

        if ($request->has('description')) {
            $product->description = $request->description;
        }

        $product->save();

        return redirect()->route('catalog.index')->with('success', 'Katalog produk beserta gambar berhasil diperbarui.');
    }
}
