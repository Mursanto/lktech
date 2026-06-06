<?php
/**
 * ========================================================
 * FILE SEMENTARA - HAPUS SETELAH MIGRATION BERHASIL!
 * TEMPORARY FILE - DELETE AFTER MIGRATION IS DONE!
 * ========================================================
 * 
 * Cara pakai / How to use:
 * 1. Upload file ini ke public_html/lktech.online/public/
 * 2. Akses via browser: https://lktech.online/run-migrate.php
 * 3. Jika berhasil, hapus file ini segera dari hosting!
 */

// Security: hanya izinkan akses jika mengirim token yang benar
$secret = 'LKTECH_MIGRATE_2026_SECURE';
$inputToken = $_GET['token'] ?? '';

if ($inputToken !== $secret) {
    http_response_code(403);
    die('<h2 style="color:red;">403 Forbidden - Token tidak valid</h2>');
}

// Bootstrap Laravel application
define('LARAVEL_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo '<html><head><title>Migration Runner</title></head>';
echo '<body style="font-family: monospace; background: #1a1a2e; color: #0f3460; padding: 20px;">';
echo '<div style="background: #16213e; color: #e94560; padding: 20px; border-radius: 8px;">';
echo '<h2 style="color: #e94560;">🚀 LKTech Migration Runner</h2>';
echo '<pre style="background: #0f3460; color: #a8dadc; padding: 15px; border-radius: 5px; overflow-x:auto;">';

try {
    // Cek apakah kolom tipe_stok sudah ada
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing('products');
    
    if (in_array('tipe_stok', $columns)) {
        echo "✅ Kolom 'tipe_stok' sudah ada di tabel products.\n";
        echo "   Tidak perlu menjalankan migration.\n\n";
    } else {
        echo "⏳ Kolom 'tipe_stok' belum ada. Menjalankan migration...\n\n";
        
        // Jalankan migration
        $exitCode = \Illuminate\Support\Facades\Artisan::call('migrate', [
            '--force' => true,
        ]);
        
        $output = \Illuminate\Support\Facades\Artisan::output();
        echo $output . "\n";
        
        if ($exitCode === 0) {
            echo "\n✅ Migration berhasil dijalankan!\n";
        } else {
            echo "\n❌ Migration gagal. Exit code: " . $exitCode . "\n";
        }
    }
    
    // Tampilkan semua kolom tabel products
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing('products');
    echo "\n📋 Kolom tabel 'products' saat ini:\n";
    foreach ($columns as $col) {
        $marker = $col === 'tipe_stok' ? ' ← BARU!' : '';
        echo "   - {$col}{$marker}\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " (Line: " . $e->getLine() . ")\n";
}

echo '</pre>';
echo '<p style="color: #e94560; font-weight: bold; margin-top: 15px;">⚠️ HAPUS FILE INI SEGERA SETELAH SELESAI!</p>';
echo '</div></body></html>';
