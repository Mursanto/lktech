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
    Route::resource('promo-video', App\Http\Controllers\Admin\PromoVideoController::class)->names('admin.promo-video');
});

// 2. AKSES KASIR (Admin & Staff) - Bisa Modify
Route::middleware(['auth', 'role:Admin|Staff'])->group(function () {
    Route::post('/sales/{sale}/mark-paid', [SaleController::class, 'markAsPaid'])->name('sales.mark-paid');
    Route::post('/sales/{sale}/complete', [SaleController::class, 'completeOrder'])->name('sales.complete');
    Route::patch('/sales/{sale}/cancel', [SaleController::class, 'cancel'])->name('sales.cancel');
    Route::patch('/sales/{sale}/update-date', [SaleController::class, 'updateDate'])->name('sales.update-date');
    Route::resource('sales', SaleController::class)->except(['index', 'show']);
    Route::patch('/rentals/{rental}/cancel', [RentalController::class, 'cancel'])->name('rentals.cancel');
    Route::resource('rentals', RentalController::class)->except(['index', 'show']);
});

// 3. AKSES SERVIS (Admin & Teknisi & Staff) - Bisa Modify
Route::middleware(['auth', 'role:Admin|Teknisi|Staff'])->group(function () {
    Route::patch('/services/{service}/cancel', [ServiceController::class, 'cancel'])->name('services.cancel');
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
        if (!function_exists('exec')) {
            return "<b>Error:</b> Fungsi exec() dinonaktifkan di server hosting Anda (biasanya karena alasan keamanan cPanel). Anda harus menjalankan composer install via terminal SSH atau lokal.";
        }

        $output = [];
        $output[] = "<b>Memulai Deployment Sistem...</b><br>";

        // 1. Eksekusi Git Pull
        exec('git pull origin main 2>&1', $outGit, $retGit);
        $output[] = "<b>Git Pull Status:</b><br>" . nl2br(implode("\n", $outGit)) . "<br>";

        // 2. Eksekusi Composer Install
        putenv('COMPOSER_HOME=' . storage_path('framework/cache'));
        exec('composer install --no-dev --optimize-autoloader 2>&1', $outComp, $retComp);
        $output[] = "<b>Composer Install Status:</b><br>" . nl2br(implode("\n", $outComp)) . "<br>";

        // 3. Clear Cache
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        $output[] = "<b>Optimize Clear:</b> Berhasil membersihkan cache Laravel.<br>";

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
