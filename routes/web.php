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

Route::get('/', [App\Http\Controllers\PublicCatalogController::class, 'index'])->name('home');
Route::get('/katalog', [App\Http\Controllers\PublicCatalogController::class, 'katalog'])->name('katalog.index');
Route::post('/katalog/contact', [App\Http\Controllers\PublicCatalogController::class, 'contact'])->name('katalog.contact');
Route::get('/katalog/{product}', [App\Http\Controllers\PublicCatalogController::class, 'show'])->name('katalog.show');

// Cart & Hybrid Checkout Routes
Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout/process', [App\Http\Controllers\CartController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{order_id}', [App\Http\Controllers\CartController::class, 'success'])->name('checkout.success');

// Static Pages
Route::view('/tentang-kami', 'pages.tentang-kami')->name('tentang-kami');
Route::view('/kebijakan-garansi', 'pages.kebijakan-garansi')->name('kebijakan-garansi');
Route::get('/rakit-pc', [App\Http\Controllers\PublicRakitPcController::class, 'index'])->name('rakit-pc');
Route::get('/jasa-website', [PageController::class, 'jasaWebsite'])->name('jasa-website');

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

});

// 2. AKSES KASIR (Admin & Staff) - Bisa Modify
Route::middleware(['auth', 'role:Admin|Staff'])->group(function () {
    Route::post('/sales/{sale}/mark-paid', [SaleController::class, 'markAsPaid'])->name('sales.mark-paid');
    Route::resource('sales', SaleController::class)->except(['index', 'show']);
    Route::resource('rentals', RentalController::class)->except(['index', 'show']);
});

// 3. AKSES SERVIS (Admin & Teknisi & Staff) - Bisa Modify
Route::middleware(['auth', 'role:Admin|Teknisi|Staff'])->group(function () {
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
    });
});

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

require __DIR__.'/auth.php';
