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

// Static Pages
Route::view('/tentang-kami', 'pages.tentang-kami')->name('tentang-kami');
Route::view('/kebijakan-garansi', 'pages.kebijakan-garansi')->name('kebijakan-garansi');

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
    Route::resource('posts', App\Http\Controllers\Admin\PostController::class);
});

// 2. AKSES KASIR (Admin & Staff) - Bisa Modify
Route::middleware(['auth', 'role:Admin|Staff'])->group(function () {
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



// Fallback route for storage images (useful for shared hosting without symlinks)
Route::get('/storage/{path}', function($path) {
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) {
        abort(404);
    }
    return response()->file($filePath);
})->where('path', '.*');

// Temporary: Cache Clear Route (hapus setelah digunakan)
Route::get('/clear-server-cache', function() {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return 'Cache server berhasil dibersihkan secara total, Kawan!';
});

require __DIR__.'/auth.php';
