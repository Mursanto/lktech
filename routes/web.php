<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfitAuditController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SetupRoleController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/run-migration-live', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return "Migration and Storage Link successful! You can now access the web normally.";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

Route::get('/run-performance-optimize', function() {
    $results = [];
    try {
        // 1. Generate WebP Thumbnails untuk produk lama
        \Illuminate\Support\Facades\Artisan::call('images:generate-thumbnails');
        $results['generate_thumbnails'] = \Illuminate\Support\Facades\Artisan::output();

        // 2. Clear cache & views
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        $results['optimize_clear'] = \Illuminate\Support\Facades\Artisan::output();

        // 3. Storage Link check
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        $results['storage_link'] = \Illuminate\Support\Facades\Artisan::output();

        // 4. Sample verification
        $sampleProduct = \App\Models\Product::whereNotNull('image_path')->orderBy('id', 'desc')->first();

        $outputHtml = "<div style='font-family:-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif; max-width:800px; margin:40px auto; padding:28px; border:1px solid #e2e8f0; border-radius:16px; background:#fff; box-shadow:0 10px 25px -5px rgba(0,0,0,0.05);'>";
        $outputHtml .= "<div style='display:flex; align-items:center; gap:12px; margin-bottom:20px;'><span style='font-size:32px;'>🚀</span><div><h2 style='color:#16a34a; margin:0; font-size:20px;'>Optimasi Performa & Thumbnails Berhasil Dijalankan!</h2><p style='color:#64748b; margin:4px 0 0; font-size:13px;'>Semua cache dibersihkan & varian thumbnail WebP telah siap disajikan.</p></div></div>";
        $outputHtml .= "<hr style='border:0; border-top:1px solid #f1f5f9; margin:20px 0;'>";
        $outputHtml .= "<h4 style='color:#1e293b; margin:16px 0 8px; font-size:14px;'>1. Output Pembuatan Thumbnail (images:generate-thumbnails):</h4><pre style='background:#f8fafc; border:1px solid #e2e8f0; padding:12px; border-radius:8px; font-size:12px; color:#334155; overflow-x:auto; max-height:220px;'>" . htmlspecialchars($results['generate_thumbnails'] ?: 'Thumbnails siap dan up to date.') . "</pre>";
        $outputHtml .= "<h4 style='color:#1e293b; margin:16px 0 8px; font-size:14px;'>2. Output Pembersihan Cache (optimize:clear):</h4><pre style='background:#f8fafc; border:1px solid #e2e8f0; padding:12px; border-radius:8px; font-size:12px; color:#334155; overflow-x:auto;'>" . htmlspecialchars($results['optimize_clear']) . "</pre>";
        if ($sampleProduct) {
            $outputHtml .= "<h4 style='color:#1e293b; margin:16px 0 8px; font-size:14px;'>3. Verifikasi Produk Sampel Terbaru:</h4>";
            $outputHtml .= "<div style='background:#f8fafc; border:1px solid #e2e8f0; padding:16px; border-radius:8px; font-size:13px; line-height:1.7;'>";
            $outputHtml .= "<div><strong>Produk:</strong> " . htmlspecialchars($sampleProduct->brand . ' ' . $sampleProduct->model_series) . "</div>";
            $outputHtml .= "<div><strong>Gambar Utama:</strong> <a href='" . $sampleProduct->display_image . "' target='_blank' style='color:#2563eb;'>" . $sampleProduct->display_image . "</a></div>";
            $outputHtml .= "<div><strong>Thumbnail (600px WebP):</strong> <a href='" . $sampleProduct->display_thumbnail . "' target='_blank' style='color:#16a34a; font-weight:600;'>" . $sampleProduct->display_thumbnail . "</a></div>";
            $outputHtml .= "</div>";
        }
        $outputHtml .= "<div style='margin-top:28px; display:flex; gap:12px; flex-wrap:wrap;'>";
        $outputHtml .= "<a href='/' style='background:#2563eb; color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:600; font-size:14px;'>Buka Beranda LKTech</a>";
        $outputHtml .= "<a href='https://pagespeed.web.dev/analysis/https-lktech-online/ysndbevuvf?form_factor=mobile' target='_blank' style='background:#16a34a; color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:600; font-size:14px;'>Cek Ulang PageSpeed Insights</a>";
        $outputHtml .= "</div></div>";

        return response($outputHtml);
    } catch (\Exception $e) {
        return response("<div style='font-family:sans-serif; padding:24px; color:#dc2626;'><h3>❌ Terjadi Error:</h3><p>" . htmlspecialchars($e->getMessage()) . "</p></div>", 500);
    }
});

Route::get('/', [App\Http\Controllers\PublicCatalogController::class, 'index'])->name('home');
Route::get('/katalog', [App\Http\Controllers\PublicCatalogController::class, 'katalog'])->name('katalog.index');
Route::post('/katalog/contact', [App\Http\Controllers\PublicCatalogController::class, 'contact'])->name('katalog.contact');
Route::get('/katalog/{product}', [App\Http\Controllers\PublicCatalogController::class, 'show'])->name('katalog.show');

// Cart & Hybrid Checkout Routes
Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/empty', [App\Http\Controllers\CartController::class, 'empty'])->name('cart.empty');
Route::post('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::get('/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout/process', [App\Http\Controllers\CartController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{order_id}', [App\Http\Controllers\CartController::class, 'success'])->name('checkout.success');
Route::get('/checkout/success/{order_id}/invoice', [App\Http\Controllers\CartController::class, 'downloadInvoice'])->name('checkout.invoice');

// Orders History & Polling API
Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
Route::post('/api/guest-orders', [App\Http\Controllers\OrderController::class, 'getGuestOrders']);
Route::get('/api/check-order-status/{id}', [App\Http\Controllers\OrderController::class, 'checkStatus']);
Route::patch('/checkout/cancel/{id}', [App\Http\Controllers\OrderController::class, 'cancelOrder'])->name('checkout.cancel');

// Static Pages
Route::view('/tentang-kami', 'pages.tentang-kami')->name('tentang-kami');
Route::view('/faq', 'pages.faq')->name('faq');
// Redirect lama /kebijakan-garansi -> /faq (agar link lama tidak broken)
Route::redirect('/kebijakan-garansi', '/faq', 301)->name('kebijakan-garansi');
Route::get('/rakit-pc', [App\Http\Controllers\PublicRakitPcController::class, 'index'])->name('rakit-pc');
Route::get('/jasa-website', [PageController::class, 'jasaWebsite'])->name('jasa-website');
Route::get('/wifi-voucher', [PageController::class, 'wifiVoucher'])->name('wifi-voucher');
Route::view('/jasa-furniture', 'pages.jasa-furniture')->name('jasa-furniture');
Route::view('/martabak-jawara', 'pages.martabak-jawara')->name('martabak-jawara');
Route::view('/layanan/limbah-elektronik', 'pages.limbah-elektronik')->name('limbah-elektronik');
Route::redirect('/bintang-scrap', '/layanan/limbah-elektronik', 301);
Route::get('/service-pc', [PageController::class, 'servicePc'])->name('service-pc');
Route::get('/sewa-laptop', [PageController::class, 'sewaLaptop'])->name('sewa-laptop');

// Public Tracking APIs
Route::get('/api/track-service', [PageController::class, 'trackService']);
Route::get('/api/track-rental', [PageController::class, 'trackRental']);
Route::get('/api/list-services', [PageController::class, 'listServices']);
Route::get('/api/list-rentals', [PageController::class, 'listRentals']);

// Blog Public Routes
Route::get('/blog', [App\Http\Controllers\PublicBlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [App\Http\Controllers\PublicBlogController::class, 'show'])->name('blog.show');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// 2FA routes
Route::middleware(['auth'])->group(function () {
    Route::get('/2fa/setup', [TwoFactorController::class, 'showSetup'])->name('2fa.setup');
    Route::post('/2fa/enable', [TwoFactorController::class, 'enable'])->name('2fa.enable');
    Route::post('/2fa/disable', [TwoFactorController::class, 'disable'])->name('2fa.disable');
    Route::post('/2fa/email/enable', [TwoFactorController::class, 'enableEmailOtp'])->name('2fa.email.enable');
    Route::post('/2fa/email/disable', [TwoFactorController::class, 'disableEmailOtp'])->name('2fa.email.disable');
});

Route::get('/2fa/verify', [TwoFactorController::class, 'showVerification'])->name('2fa.verify');
Route::post('/2fa/verify', [TwoFactorController::class, 'verify'])->name('2fa.verify.post');

// 2. AKSES KHUSUS ADMIN (Keuangan, Log, & Manajemen Produk Penuh) -> PINDAHKAN KE ATAS
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
    Route::resource('products', ProductController::class)->except(['index', 'show']);
    Route::resource('catalog', App\Http\Controllers\CatalogController::class)->only(['edit', 'update']);
    Route::get('/sales/export', [SaleController::class, 'export'])->name('sales.export');
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('categories', App\Http\Controllers\CategoryController::class);
    
    // Google Reviews
    Route::get('google-reviews', [App\Http\Controllers\Admin\GoogleReviewController::class, 'index'])->name('google-reviews.index');
    Route::post('google-reviews', [App\Http\Controllers\Admin\GoogleReviewController::class, 'store'])->name('google-reviews.store');
    Route::put('google-reviews/{googleReview}', [App\Http\Controllers\Admin\GoogleReviewController::class, 'update'])->name('google-reviews.update');
    Route::delete('google-reviews/{googleReview}', [App\Http\Controllers\Admin\GoogleReviewController::class, 'destroy'])->name('google-reviews.destroy');
    Route::post('google-reviews/{googleReview}/toggle', [App\Http\Controllers\Admin\GoogleReviewController::class, 'toggleFeatured'])->name('google-reviews.toggle');
    Route::post('google-reviews/{googleReview}/reply', [App\Http\Controllers\Admin\GoogleReviewController::class, 'reply'])->name('google-reviews.reply');

    // Promo Video
    Route::patch('promo-video/{promo_video}/toggle', [App\Http\Controllers\Admin\PromoVideoController::class, 'toggleActive'])->name('admin.promo-video.toggle');
    Route::resource('promo-video', App\Http\Controllers\Admin\PromoVideoController::class)->names('admin.promo-video');

    // Investor Management
    Route::get('investors/{investor}/pks', [App\Http\Controllers\InvestorController::class, 'downloadPks'])->name('investors.pks');
    Route::resource('investors', App\Http\Controllers\InvestorController::class);
    Route::get('/investor-report', [App\Http\Controllers\InvestorReportController::class, 'index'])->name('investor.report');
    Route::get('/investor-report/export', [App\Http\Controllers\InvestorReportController::class, 'export'])->name('investor.report.export');
    Route::post('/investor-report/bulk-payout', [App\Http\Controllers\InvestorReportController::class, 'processBulkPayout'])->name('investor.report.bulk-payout');
});

// Investor Dashboard (Read-Only) â€” role Investor
Route::middleware(['auth', 'role:Investor'])->group(function () {
    Route::get('/investor/dashboard', [App\Http\Controllers\InvestorReportController::class, 'dashboard'])->name('investor.dashboard');
    Route::get('/investor/dashboard/export', [App\Http\Controllers\InvestorReportController::class, 'exportDashboard'])->name('investor.dashboard.export');
    
    // Legal & PKS
    Route::get('/investor/legal', [App\Http\Controllers\InvestorLegalController::class, 'index'])->name('investor.legal.index');
    Route::post('/investor/legal/agree', [App\Http\Controllers\InvestorLegalController::class, 'agree'])->name('investor.legal.agree');
    Route::get('/investor/legal/export', [App\Http\Controllers\InvestorLegalController::class, 'exportPdf'])->name('investor.legal.export');
});

// 2. AKSES KASIR (Admin & Staff) - Bisa Modify
Route::middleware(['auth', 'role:Admin|Staff'])->group(function () {
    Route::post('/sales/{sale}/mark-paid', [SaleController::class, 'markAsPaid'])->name('sales.mark-paid');
    Route::post('/sales/{sale}/complete', [SaleController::class, 'completeOrder'])->name('sales.complete');
    Route::post('/sales/{sale}/resend-invoice', [SaleController::class, 'resendInvoice'])->name('sales.resend_invoice');
    Route::patch('/sales/{sale}/cancel', [SaleController::class, 'cancel'])->name('sales.cancel');
    Route::patch('/sales/{sale}/update-date', [SaleController::class, 'updateDate'])->name('sales.update-date');
    Route::resource('sales', SaleController::class)->except(['index', 'show']);
    Route::patch('/rentals/{rental}/cancel', [RentalController::class, 'cancel'])->name('rentals.cancel');
    Route::post('/rentals/{rental}/resend-invoice', [RentalController::class, 'resendInvoice'])->name('rentals.resend_invoice');
    Route::resource('rentals', RentalController::class)->except(['index', 'show']);
});

// 3. AKSES SERVIS (Admin & Teknisi & Staff) - Bisa Modify
Route::middleware(['auth', 'role:Admin|Teknisi|Staff'])->group(function () {
    Route::patch('/services/{service}/cancel', [ServiceController::class, 'cancel'])->name('services.cancel');
    Route::post('/services/{service}/resend-invoice', [ServiceController::class, 'resendInvoice'])->name('services.resend_invoice');
    Route::resource('services', ServiceController::class)->except(['index', 'show']);
});

// 1. AKSES GLOBAL (View Only untuk semua yang sudah login termasuk Demo)
Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class)->only(['index', 'show']);
    Route::resource('catalog', App\Http\Controllers\CatalogController::class)->only(['index']);
    
    // Sales View Only
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
    Route::get('/sales/{sale}/invoice', [SaleController::class, 'generateInvoice'])->name('sales.invoice');
    Route::get('/sales/{sale}/print', [SaleController::class, 'print'])->name('sales.print');
    
    // Services View Only
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/export', [ServiceController::class, 'export'])->name('services.export');
    Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('/services/{service}/print', [ServiceController::class, 'print'])->name('services.print');
    
    // Rentals View Only
    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
    Route::get('/rentals/export', [RentalController::class, 'export'])->name('rentals.export');
    Route::get('/rentals/{rental}', [RentalController::class, 'show'])->name('rentals.show');
});

// Additional routes (keeping existing structure)
Route::middleware(['auth'])->group(function () {
    // Activity Logs (Admin only)
    Route::get('/activity-logs/export', [ActivityLogController::class, 'export'])->name('activity-logs.export');
    Route::get('/activity-logs/{activityLog}', [ActivityLogController::class, 'show'])->name('activity-logs.show');
    Route::delete('/activity-logs/clear', [ActivityLogController::class, 'clearLogs'])->name('activity-logs.clear');
    Route::get('/activity-logs/backup', [ActivityLogController::class, 'backupDatabase'])->name('activity-logs.backup');
    
    // Reports
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    Route::get('/reports/profit-loss/export', [ReportController::class, 'profitLossExport'])->name('reports.profit-loss.export');
    Route::get('/reports/profit', [ReportController::class, 'profit'])->name('reports.profit');
    
    // Laporan (Indonesian Reports)
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
    
    // Profit Audit Routes (Admin only)
    Route::middleware(['auth', 'role:Admin'])->group(function () {
        Route::get('/profit-audit', [ProfitAuditController::class, 'auditAndRecalculateAll'])->name('profit.audit');
        Route::get('/profit-validate', [ProfitAuditController::class, 'validateDashboardCalculations'])->name('profit.validate');
        Route::post('/profit-recalculate/{saleId}', [ProfitAuditController::class, 'recalculateSaleProfit'])->name('profit.recalculate');

        // Route sementara: Hapus constraint unique di tabel customers (khusus Admin)
        Route::get('/admin/fix-customer-constraint', function () {
            try {
                // Cek apakah index ada
                $indexExists = \DB::select("
                    SELECT INDEX_NAME FROM INFORMATION_SCHEMA.STATISTICS 
                    WHERE TABLE_SCHEMA = DATABASE() 
                      AND TABLE_NAME = 'customers' 
                      AND INDEX_NAME = 'customers_unique_fields'
                ");

                if (empty($indexExists)) {
                    return response()->json([
                        'status' => 'already_done',
                        'message' => 'Index customers_unique_fields sudah tidak ada.'
                    ]);
                }

                \DB::statement('ALTER TABLE `customers` DROP INDEX `customers_unique_fields`');
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Constraint customers_unique_fields berhasil dihapus!'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], 500);
            }
        });
    }); // tutup: role:Admin group (baris 170)
}); // tutup: auth group (baris 154)

// RBAC Permissions Routes
Route::middleware(['auth', 'permission:access_blog'])->group(function () {
    Route::resource('posts', App\Http\Controllers\Admin\PostController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::middleware(['permission:access_settings'])->group(function () {
        Route::get('/settings', [\App\Http\Controllers\WebSettingController::class, 'edit'])->name('settings.index');
        Route::put('/settings', [\App\Http\Controllers\WebSettingController::class, 'update'])->name('settings.update');
        
        Route::get('/promo', [\App\Http\Controllers\PromoBannerController::class, 'edit'])->name('promo.edit');
        Route::put('/promo', [\App\Http\Controllers\PromoBannerController::class, 'update'])->name('promo.update');
    });

    // Rakit PC Admin Routes
    Route::middleware(['permission:access_rakit_pc'])->group(function () {
        Route::resource('rakit-pc-admin', App\Http\Controllers\Admin\RakitPcController::class);
    });

    // Jasa Website Admin Routes
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('jasa-website-admin', App\Http\Controllers\Admin\JasaWebsiteController::class);
        Route::resource('wifi-voucher-admin', App\Http\Controllers\Admin\WifiVoucherController::class);
    });
});


// Fallback route for storage images (useful for shared hosting without symlinks)
Route::get('/storage/{path}', function($path) {
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) {
        abort(404);
    }
    return response()->file($filePath);
})->where('path', '.*');

// Temporary Route for cPanel Shared Hosting (Run Migration & Cache Clear)
Route::get('/run-migrations', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        return 'Migrasi Database dan Clear Cache Berhasil! Silakan kembali ke halaman utama.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// Route rahasia untuk melihat error log langsung dari browser
Route::get('/read-logs', function () {
    $logFile = storage_path('logs/laravel.log');
    if (!file_exists($logFile)) {
        return "Log file tidak ditemukan atau belum ada error yang tercatat.";
    }
    
    // Ambil 500 baris terakhir dari log agar browser tidak hang
    $file = file($logFile);
    $lines = array_slice($file, -500);
    
    $content = htmlspecialchars(implode("", $lines));
    return "<pre style='background:#111; color:#0f0; padding:20px; font-family:monospace; white-space:pre-wrap; overflow-x:auto;'>" . $content . "</pre>";
});

// Route to execute Git Pull and Composer Install from Browser (For Shared Hosting)
Route::get('/deploy-system', function () {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    try {
        $output = [];
        $output[] = "<b>Memulai Deployment Sistem...</b><br>";

        // 1. Eksekusi Git Pull & Composer (Jika exec aktif)
        if (function_exists('exec')) {
            exec('git pull origin main 2>&1', $outGit, $retGit);
            $output[] = "<b>Git Pull Status:</b><br>" . nl2br(implode("\n", $outGit)) . "<br>";

            putenv('COMPOSER_HOME=' . storage_path('framework/cache'));
            exec('composer install --no-dev --optimize-autoloader 2>&1', $outComp, $retComp);
            $output[] = "<b>Composer Install Status:</b><br>" . nl2br(implode("\n", $outComp)) . "<br>";
        } else {
            $output[] = "<b>Warning:</b> Fungsi exec() dinonaktifkan. Melewati Git Pull & Composer Install.<br>";
        }

        // 3. Clear Cache
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        $output[] = "<b>Optimize Clear:</b> Berhasil membersihkan cache Laravel.<br>";

        // 4. Migrate Database
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            $output[] = "<b>Migrasi Database:</b> Berhasil (Artisan).<br>";
        } catch (\Exception $e) {
            $output[] = "<b>Migrasi Database:</b> Gagal - " . $e->getMessage() . "<br>";
        }

        // 5. Seed Investor Role
        try {
            \Illuminate\Support\Facades\Artisan::call('db:seed', [
                '--class' => 'InvestorRoleSeeder',
                '--force' => true
            ]);
            $output[] = "<b>Seed Role Investor:</b> Berhasil ditambahkan.<br>";
        } catch (\Exception $e) {
            $output[] = "<b>Seed Role Investor:</b> Gagal - " . $e->getMessage() . "<br>";
        }

        return implode("<br>", $output);
    } catch (\Throwable $e) {
        return '<b>Terjadi Kesalahan Fatal:</b> ' . $e->getMessage() . ' di file ' . $e->getFile() . ' baris ' . $e->getLine();
    }
});

Route::get('/buka-brankas', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return 'Berhasil! Pintu brankas gambar sudah dibuka.';
});

// Temporary Route to seed Wifi Voucher Packages
Route::get('/seed-wifi-voucher', function () {
    \App\Models\WifiVoucher::truncate();
    
    \App\Models\WifiVoucher::create([
        'nama_paket' => 'Skema Sharing Revenue',
        'harga' => 0,
        'badge' => 'TERPOPULER',
        'deskripsi_singkat' => 'TIDAK ADA INVESTASI AWAL, MODAL MINIMAL',
        'fitur_list' => "Paket voucher disediakan provider\nMargin Owner: Rp 2.100 (6 Jam)\nMargin Owner: Rp 5.250 (12 Jam)\nModal Minimal, Keuntungan dari Margin\nNote: Tidak ada investasi awal -> Modal minimal -> keuntungan dari margin penjualan voucher",
        'is_active' => true
    ]);

    \App\Models\WifiVoucher::create([
        'nama_paket' => 'Skema Beli Putus',
        'harga' => 18900000,
        'badge' => 'REKOMENDASI',
        'deskripsi_singkat' => 'INVESTASI PERANGKAT + CLOUD SYSTEM',
        'fitur_list' => "Kit Starlink: Perangkat satelit lengkap\nInstalasi: Bracket, Cabling, Aksesoris\nAP Outdoor: Access Point High End\nCloud System: Sistem hotspot & manajemen\nBiaya Bulanan: Rp 2.362.500 (Starlink + Support)\nnote: Investasi perangkat + Cloud system -> Aset milik owner -> Keuntungan penuh",
        'is_active' => true
    ]);

    return 'Data Paket Wifi Voucher Berhasil Ditambahkan!';
});

// Temporary Route to seed Google Reviews dummy data
Route::get('/seed-google-reviews', function () {
    $dummyReviews = [
        [
            'google_review_id' => 'dummy_1',
            'reviewer_name' => 'Budi Santoso',
            'reviewer_photo_url' => 'https://ui-avatars.com/api/?name=Budi+Santoso&background=random',
            'star_rating' => 5,
            'review_comment' => 'Pelayanan sangat memuaskan. Beli laptop bekas tapi kualitasnya seperti baru. Garansi juga jelas.',
            'review_created_at' => \Carbon\Carbon::now()->subDays(2),
            'is_featured' => true,
            'review_reply' => 'Terima kasih atas ulasan positifnya, Mas Budi! Ditunggu orderan selanjutnya.'
        ],
        [
            'google_review_id' => 'dummy_2',
            'reviewer_name' => 'Siti Aisyah',
            'reviewer_photo_url' => 'https://ui-avatars.com/api/?name=Siti+Aisyah&background=random',
            'star_rating' => 5,
            'review_comment' => 'Service laptop di sini cepat banget. Kemarin mati total, sekarang udah nyala lagi. Harga juga bersahabat.',
            'review_created_at' => \Carbon\Carbon::now()->subDays(5),
            'is_featured' => true,
            'review_reply' => null
        ],
        [
            'google_review_id' => 'dummy_3',
            'reviewer_name' => 'Ahmad Reza',
            'reviewer_photo_url' => 'https://ui-avatars.com/api/?name=Ahmad+Reza&background=random',
            'star_rating' => 4,
            'review_comment' => 'Pilihan aksesorisnya lumayan lengkap. Mungkin bisa ditambah lagi stok untuk mouse gaming-nya.',
            'review_created_at' => \Carbon\Carbon::now()->subWeeks(1),
            'is_featured' => true,
            'review_reply' => 'Terima kasih sarannya, Mas Ahmad. Kami akan usahakan restock mouse gaming secepatnya.'
        ],
        [
            'google_review_id' => 'dummy_4',
            'reviewer_name' => 'Dwi Handayani',
            'reviewer_photo_url' => null,
            'star_rating' => 5,
            'review_comment' => 'Rakit PC di LKTech mantap! Dirakit dengan rapi, kabel manajemennya bagus banget. Suhu PC juga adem.',
            'review_created_at' => \Carbon\Carbon::now()->subMonths(1),
            'is_featured' => true,
            'review_reply' => null
        ],
        [
            'google_review_id' => 'dummy_5',
            'reviewer_name' => 'Doni Kusuma',
            'reviewer_photo_url' => 'https://ui-avatars.com/api/?name=Doni+Kusuma&background=random',
            'star_rating' => 3,
            'review_comment' => 'Lumayan bagus, tapi pengiriman agak lambat karena hujan deras kemarin.',
            'review_created_at' => \Carbon\Carbon::now()->subDays(10),
            'is_featured' => false,
            'review_reply' => 'Mohon maaf atas keterlambatan pengiriman dikarenakan cuaca buruk, Kak Doni. Terima kasih masukannya.'
        ]
    ];

    foreach ($dummyReviews as $data) {
        \App\Models\GoogleReview::updateOrCreate(
            ['google_review_id' => $data['google_review_id']],
            $data
        );
    }

    return 'Data Ulasan Google Berhasil Ditambahkan!';
});

require __DIR__.'/auth.php';

Route::get('/compress-blogs-now', function () {
    ini_set('max_execution_time', 300);
    ini_set('memory_limit', '256M');

    $directory = storage_path('app/public/blogs');
    if (!is_dir($directory)) {
        return "Direktori tidak ditemukan: $directory";
    }

    $files = scandir($directory);
    $count = 0;
    $totalBefore = 0;
    $totalAfter = 0;

    $html = "<h2>Mulai Kompresi Gambar Blog ke WebP</h2><ul>";

    foreach ($files as $file) {
        if (in_array($file, ['.', '..'])) continue;
        
        $filePath = $directory . '/' . $file;
        $info = pathinfo($filePath);
        $ext = strtolower($info['extension'] ?? '');
        
        if (in_array($ext, ['png', 'jpg', 'jpeg'])) {
            $webpPath = $directory . '/' . $info['filename'] . '.webp';
            
            if (file_exists($webpPath)) {
                continue;
            }
            
            $beforeSize = filesize($filePath);
            $image = null;
            
            if ($ext === 'png') {
                $image = @imagecreatefrompng($filePath);
                if ($image) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
            } else {
                $image = @imagecreatefromjpeg($filePath);
            }
            
            if ($image) {
                $width = imagesx($image);
                $height = imagesy($image);
                
                if ($width > 800) {
                    $ratio = 800 / $width;
                    $newHeight = $height * $ratio;
                    $newImage = imagecreatetruecolor(800, $newHeight);
                    
                    if ($ext === 'png') {
                        imagealphablending($newImage, false);
                        imagesavealpha($newImage, true);
                        $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                        imagefilledrectangle($newImage, 0, 0, 800, $newHeight, $transparent);
                    }
                    
                    imagecopyresampled($newImage, $image, 0, 0, 0, 0, 800, $newHeight, $width, $height);
                    $image = $newImage;
                }
                
                if (imagewebp($image, $webpPath, 80)) {
                    $afterSize = filesize($webpPath);
                    $totalBefore += $beforeSize;
                    $totalAfter += $afterSize;
                    $count++;
                    
                    $beforeKb = round($beforeSize / 1024);
                    $afterKb = round($afterSize / 1024);
                    
                    $html .= "<li>OK: <b>$file</b> ($beforeKb KB &rarr; $afterKb KB)</li>";
                } else {
                    $html .= "<li><span style='color:red'>Gagal menyimpan: $file</span></li>";
                }
                
                imagedestroy($image);
            }
        }
    }

    $html .= "</ul>";

    if ($count > 0) {
        $saved = round(($totalBefore - $totalAfter) / 1024);
        $html .= "<h3>Selesai! $count gambar berhasil dikompresi.</h3>";
        $html .= "<p>Total penghematan: <b>$saved KB</b></p>";
    } else {
        $html .= "<h3>Tidak ada gambar baru yang perlu dikompresi.</h3>";
    }
    
    return $html;
});


Route::get('/compress-catalog-now', function () {
    ini_set('max_execution_time', 600); // 10 menit
    ini_set('memory_limit', '512M');

    $directory = storage_path('app/public/catalog');
    if (!is_dir($directory)) {
        return "Direktori tidak ditemukan: $directory";
    }

    $files = scandir($directory);
    $count = 0;
    $totalBefore = 0;
    $totalAfter = 0;

    $html = "<h2>Mulai Kompresi Gambar Katalog ke WebP</h2><ul>";

    foreach ($files as $file) {
        if (in_array($file, ['.', '..'])) continue;
        
        $filePath = $directory . '/' . $file;
        $info = pathinfo($filePath);
        $ext = strtolower($info['extension'] ?? '');
        
        // Sertakan jfif, jpeg, jpg, png
        if (in_array($ext, ['png', 'jpg', 'jpeg', 'jfif'])) {
            $webpPath = $directory . '/' . $info['filename'] . '.webp';
            
            if (file_exists($webpPath)) {
                continue;
            }
            
            $beforeSize = filesize($filePath);
            $image = null;
            
            if ($ext === 'png') {
                $image = @imagecreatefrompng($filePath);
                if ($image) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
            } else {
                $image = @imagecreatefromjpeg($filePath);
            }
            
            if ($image) {
                $width = imagesx($image);
                $height = imagesy($image);
                
                // Max lebar 800px untuk katalog
                if ($width > 800) {
                    $ratio = 800 / $width;
                    $newHeight = $height * $ratio;
                    $newImage = imagecreatetruecolor(800, $newHeight);
                    
                    if ($ext === 'png') {
                        imagealphablending($newImage, false);
                        imagesavealpha($newImage, true);
                        $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                        imagefilledrectangle($newImage, 0, 0, 800, $newHeight, $transparent);
                    }
                    
                    imagecopyresampled($newImage, $image, 0, 0, 0, 0, 800, $newHeight, $width, $height);
                    $image = $newImage;
                }
                
                if (imagewebp($image, $webpPath, 80)) {
                    $afterSize = filesize($webpPath);
                    $totalBefore += $beforeSize;
                    $totalAfter += $afterSize;
                    $count++;
                    
                    $beforeKb = round($beforeSize / 1024);
                    $afterKb = round($afterSize / 1024);
                    
                    $html .= "<li>OK: <b>$file</b> ($beforeKb KB &rarr; $afterKb KB)</li>";
                } else {
                    $html .= "<li><span style='color:red'>Gagal menyimpan WebP: $file</span></li>";
                }
                
                imagedestroy($image);
            }
        }
    }

    $html .= "</ul>";

    if ($count > 0) {
        $saved = round(($totalBefore - $totalAfter) / 1024);
        $html .= "<h3>Selesai! $count gambar katalog berhasil dikompresi.</h3>";
        $html .= "<p>Total penghematan: <b>$saved KB</b></p>";
    } else {
        $html .= "<h3>Tidak ada gambar katalog baru yang perlu dikompresi.</h3>";
    }
    
    return $html;
});

// ===============================================================
// EMERGENCY: Hapus file asli dari storage setelah konversi WebP
// agar disk server tidak penuh → akses: /emergency-cleanup-storage
// ===============================================================
Route::get('/emergency-cleanup-storage', function () {
    ini_set('max_execution_time', 300);
    
    $html = "<h1 style='color:darkred'>🔧 Emergency Storage Cleanup</h1>";
    $html .= "<p>Menghapus file asli (.png/.jpg/.jpeg/.jfif) yang sudah ada versi .webp-nya...</p><ul>";
    
    $directories = [
        'catalog' => storage_path('app/public/catalog'),
        'blogs'   => storage_path('app/public/blogs'),
    ];
    
    $totalDeleted = 0;
    $totalFreed = 0;
    
    foreach ($directories as $dirName => $directory) {
        if (!is_dir($directory)) continue;
        
        $html .= "<li><strong>Folder: $dirName</strong><ul>";
        
        foreach (scandir($directory) as $file) {
            if (in_array($file, ['.', '..'])) continue;
            
            $filePath = $directory . '/' . $file;
            $info = pathinfo($filePath);
            $ext = strtolower($info['extension'] ?? '');
            
            if (!in_array($ext, ['png', 'jpg', 'jpeg', 'jfif'])) continue;
            
            $webpPath = $directory . '/' . $info['filename'] . '.webp';
            
            // Hanya hapus jika versi webp SUDAH ADA
            if (!file_exists($webpPath)) {
                $html .= "<li style='color:orange'>LEWATI (tidak ada webp): <b>$file</b></li>";
                continue;
            }
            
            $sizeKb = round(filesize($filePath) / 1024);
            
            if (@unlink($filePath)) {
                $totalFreed += $sizeKb;
                $totalDeleted++;
                $html .= "<li style='color:green'>✓ Dihapus: <b>$file</b> ($sizeKb KB)</li>";
            } else {
                $html .= "<li style='color:red'>✗ Gagal hapus: <b>$file</b></li>";
            }
        }
        
        $html .= "</ul></li>";
    }
    
    $html .= "</ul>";
    $html .= "<h2 style='color:green'>Selesai! $totalDeleted file dihapus, disk dibebaskan: <b>$totalFreed KB</b></h2>";
    
    return $html;
});
