<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicCatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')
                    ->where(function($q) {
                        $q->where(function($q1) {
                            $q1->where('stock', '>', 0)
                               ->where('status', '!=', 'sold');
                        })->orWhereNotNull('image_path');
                    });

        // Removed category filter to show all in-stock products on the landing page

        // Sort Filter
        if ($request->has('sort')) {
            if ($request->sort == 'tertinggi') {
                $query->orderBy('selling_price', 'desc');
            } elseif ($request->sort == 'terendah') {
                $query->orderBy('selling_price', 'asc');
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                  ->orWhere('model_series', 'like', "%{$search}%")
                  ->orWhere('processor', 'like', "%{$search}%")
                  ->orWhereHas('category', function($cat) use ($search) {
                      $cat->where('name', 'like', "%{$search}%");
                  });
            });
            $products = $query->paginate(12)->withQueryString();
            $collectionToTransform = $products->getCollection();
        } else {
            $products = $query->take(12)->get();
            $collectionToTransform = $products;
        }

        $collectionToTransform->transform(function ($product) {
            if ($product->image_path) {
                $product->display_image = Storage::url($product->image_path);
            } else {
                $searchQuery = urlencode($product->brand . ' ' . $product->model_series . ' laptop');
                $product->display_image = "https://source.unsplash.com/400x400/?{$searchQuery}";
            }
            return $product;
        });

        $latestPosts = collect();
        try {
            $latestPosts = \App\Models\Post::where('is_published', true)
                ->latest('published_at')
                ->take(4)
                ->get();
        } catch (\Exception $e) {
            // Abaikan jika tabel posts belum dimigrasi di server produksi
        }

        $setting = \App\Models\WebSetting::first();

        return view('welcome', compact('products', 'latestPosts', 'setting'));
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

    public function katalog(Request $request)
    {
        try {
            \App\Models\CatalogVisitor::firstOrCreate([
                'ip_address' => $request->ip(),
                'visited_at' => now()->toDateString(),
            ]);
        } catch (\Exception $e) {
            // Ignore error if table is not yet migrated
        }

        $mainCategories = \App\Models\Category::whereNull('parent_id')->with('children')->get();
        $selectedCategoryId = $request->category_id;

        $displayCategories = $mainCategories;
        if ($selectedCategoryId) {
            $displayCategories = $mainCategories->where('id', $selectedCategoryId);
        }

        foreach($mainCategories as $category) {
            $categoryIds = $category->children->pluck('id')->push($category->id)->toArray();
            $category->total_count = \App\Models\Product::whereIn('category_id', $categoryIds)
                                        ->where(function($q) {
                                            $q->where(function($q1) {
                                                $q1->where('stock', '>', 0)
                                                   ->where('status', '!=', 'sold');
                                            })->orWhereNotNull('image_path');
                                        })
                                        ->count();
        }

        foreach($displayCategories as $category) {
            $categoryIds = $category->children->pluck('id')->push($category->id)->toArray();
            
            $query = \App\Models\Product::with('category')->whereIn('category_id', $categoryIds)
                        ->where(function($q) {
                            $q->where(function($q1) {
                                $q1->where('stock', '>', 0)
                                   ->where('status', '!=', 'sold');
                            })->orWhereNotNull('image_path');
                        });
            
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('brand', 'like', "%{$search}%")
                      ->orWhere('model_series', 'like', "%{$search}%")
                      ->orWhere('processor', 'like', "%{$search}%")
                      ->orWhereHas('category', function($cat) use ($search) {
                          $cat->where('name', 'like', "%{$search}%");
                      });
                });
            }

            if ($request->has('sort')) {
                if ($request->sort == 'tertinggi') {
                    $query->orderBy('selling_price', 'desc');
                } elseif ($request->sort == 'terendah') {
                    $query->orderBy('selling_price', 'asc');
                } else {
                    $query->latest();
                }
            } else {
                $query->latest();
            }

            if (!$selectedCategoryId && !$request->has('search')) {
                $products = $query->take(5)->get();
                $collectionToTransform = $products;
            } else {
                $products = $query->paginate(12)->withQueryString();
                $collectionToTransform = $products->getCollection();
            }

            $collectionToTransform->transform(function ($product) {
                if ($product->image_path) {
                    $product->display_image = Storage::url($product->image_path);
                } else {
                    $searchQuery = urlencode($product->brand . ' ' . $product->model_series . ' laptop');
                    $product->display_image = "https://source.unsplash.com/400x400/?{$searchQuery}";
                }
                return $product;
            });
            
            $category->all_products = $products;
        }

        return view('katalog.index', compact('mainCategories', 'displayCategories', 'selectedCategoryId'));
    }

    public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to('sales@lktech.online')
                ->send(new \App\Mail\ContactUsMail($request->all()));
        } catch (\Exception $e) {
            // Ignore if email failed (SMTP might not be configured on local or test)
            \Illuminate\Support\Facades\Log::error('Failed to send contact email: ' . $e->getMessage());
        }

        return back()->with('success', 'Pesan Anda berhasil dikirim! Tim kami akan segera menghubungi Anda.');
    }
}
