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

        // Fetch Featured Products
        $featuredIds = [46, 23, 22, 33, 36];
        $featuredKeywords = ['Caddy 12.7mm', 'Caddy']; // Fallback since ID 22 was provided twice
        
        $featuredProducts = \App\Models\Product::with('category')
            ->where(function($q) use ($featuredIds, $featuredKeywords) {
                $q->whereIn('id', $featuredIds);
                foreach($featuredKeywords as $keyword) {
                    $q->orWhere('model_series', 'like', "%{$keyword}%")
                      ->orWhere('brand', 'like', "%{$keyword}%");
                }
            })
            ->where('stock', '>', 0)
            ->where('status', '!=', 'sold')
            ->take(6)
            ->get();
            
        $featuredProducts->transform(function ($product) {
            if ($product->image_path) {
                $product->display_image = Storage::url($product->image_path);
            } else {
                $searchQuery = urlencode($product->brand . ' ' . $product->model_series);
                $product->display_image = "https://source.unsplash.com/400x400/?{$searchQuery}";
            }
            return $product;
        });

        return view('welcome', compact('products', 'latestPosts', 'setting', 'featuredProducts'));
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

        // Fixed Pinned Product: ID 23 (Microsoft Office LTSC 2024)
        $pinnedProductId = 23;
        $pinnedProduct = null;

        if ($product->id != $pinnedProductId) {
            $pinnedProduct = \App\Models\Product::with('category')
                ->where('id', $pinnedProductId)
                ->where('stock', '>', 0)
                ->where('status', '!=', 'sold')
                ->first();
        }

        // Fetch Dynamic Related Products (Same category or accessories)
        $dynamicProducts = \App\Models\Product::with('category')
            ->where('id', '!=', $product->id)
            ->where('id', '!=', $pinnedProductId)
            ->where(function($q) use ($product) {
                if ($product->category_id) {
                    $q->where('category_id', $product->category_id);
                }
                $q->orWhereHas('category', function($cat) {
                    $cat->where('name', 'like', '%Aksesoris%')
                        ->orWhere('name', 'like', '%Komponen%')
                        ->orWhere('name', 'like', '%Upgrade%')
                        ->orWhere('name', 'like', '%Mouse%')
                        ->orWhere('name', 'like', '%Tas%');
                });
            })
            ->where('stock', '>', 0)
            ->where('status', '!=', 'sold')
            ->inRandomOrder()
            ->take(7)
            ->get();
            
        // Combine pinned product at slot 1, followed by dynamic products
        $relatedProducts = collect();
        if ($pinnedProduct) {
            $relatedProducts->push($pinnedProduct);
        }
        foreach ($dynamicProducts as $dp) {
            $relatedProducts->push($dp);
        }
            
        // Transform images for related products
        $relatedProducts->transform(function ($rp) {
            if ($rp->image_path) {
                $rp->display_image = Storage::url($rp->image_path);
            } else {
                $searchQuery = urlencode($rp->brand . ' ' . $rp->model_series . ' laptop');
                $rp->display_image = "https://source.unsplash.com/400x400/?{$searchQuery}";
            }
            return $rp;
        });

        return view('katalog.show', compact('product', 'relatedProducts'));
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

        // Count totals per category (eager loaded)
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

        // Collect all available brands for filter sidebar
        $availableBrands = \App\Models\Product::where('stock', '>', 0)
            ->where('status', '!=', 'sold')
            ->whereNotNull('brand')
            ->where('brand', '!=', '')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');

        $selectedBrands = $request->brands ?? [];
        $priceMin = $request->price_min ? (int) str_replace('.', '', $request->price_min) : null;
        $priceMax = $request->price_max ? (int) str_replace('.', '', $request->price_max) : null;

        foreach($displayCategories as $category) {
            $categoryIds = $category->children->pluck('id')->push($category->id)->toArray();

            $query = \App\Models\Product::with('category')->whereIn('category_id', $categoryIds)
                        ->where(function($q) {
                            $q->where(function($q1) {
                                $q1->where('stock', '>', 0)
                                   ->where('status', '!=', 'sold');
                            })->orWhereNotNull('image_path');
                        });

            // Search filter
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

            // Brand filter
            if (!empty($selectedBrands)) {
                $query->whereIn('brand', $selectedBrands);
            }

            // Price range filter
            if ($priceMin !== null) {
                $query->where('selling_price', '>=', $priceMin);
            }
            if ($priceMax !== null) {
                $query->where('selling_price', '<=', $priceMax);
            }

            // Sorting
            $sort = $request->sort ?? 'terbaru';
            switch ($sort) {
                case 'tertinggi':  $query->orderBy('selling_price', 'desc'); break;
                case 'terendah':   $query->orderBy('selling_price', 'asc');  break;
                case 'paling_laris': $query->orderBy('sold_count', 'desc')->orderBy('created_at', 'desc'); break;
                default:           $query->latest();                          break; // 'terbaru' / 'paling_sesuai'
            }

            if (!$selectedCategoryId && !$request->has('search') && empty($selectedBrands) && $priceMin === null && $priceMax === null) {
                // Preview mode: 6 products, no pagination
                $products = $query->take(6)->get();
                $collectionToTransform = $products;
            } else {
                // Detail/filtered mode: paginate with simplePaginate for performance
                $products = $query->simplePaginate(12)->withQueryString();
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

        return view('katalog.index', compact(
            'mainCategories', 'displayCategories', 'selectedCategoryId',
            'availableBrands', 'selectedBrands', 'priceMin', 'priceMax'
        ));
    }

    public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:1000', // Maksimal 1000 karakter
        ]);

        // Limit pengiriman: Maksimal 3x per alamat email per 24 jam (86400 detik)
        $rateLimitKey = 'contact_form_' . strtolower(trim($request->email));
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            return back()->withErrors(['email' => 'Anda telah mencapai batas maksimal (3x) pengiriman pesan. Silakan coba lagi besok.'])->withInput();
        }

        // Membersihkan input pesan dari tag HTML/Script untuk keamanan (Mencegah XSS)
        $cleanMessage = strip_tags($request->message);
        $data = $request->all();
        $data['message'] = $cleanMessage;

        try {
            \Illuminate\Support\Facades\Mail::to('sales@lktech.online')
                ->send(new \App\Mail\ContactUsMail($data));
            
            // Catat attempt baru sukses
            \Illuminate\Support\Facades\RateLimiter::hit($rateLimitKey, 86400);
        } catch (\Exception $e) {
            // Ignore if email failed (SMTP might not be configured on local or test)
            \Illuminate\Support\Facades\Log::error('Failed to send contact email: ' . $e->getMessage());
        }

        return back()->with('success', 'Pesan Anda berhasil dikirim! Tim kami akan segera menghubungi Anda.');
    }
}
