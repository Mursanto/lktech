<?php
/**
 * Script Deployment Khusus Tanpa Git/SSH (Bypass exec blocked)
 * Upload file ini ke folder public_html di cPanel.
 * Akses: https://lktech.online/deploy_secret.php
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<b>Memulai Deployment Khusus via ZIP GitHub...</b><br><br>";

$repoUrl = "https://github.com/Mursanto/lktech/archive/refs/heads/main.zip";
$zipFile = __DIR__ . "/main.zip";
$extractPath = __DIR__ . "/../storage/app/temp_deploy";

// 1. Download ZIP
echo "1. Mengunduh kode terbaru dari GitHub...<br>";
$context = stream_context_create([
    "http" => [
        "header" => "User-Agent: LKTech-Deploy\r\n"
    ]
]);

$zipData = file_get_contents($repoUrl, false, $context);
if ($zipData === false) {
    die("<b>Error:</b> Gagal mengunduh ZIP dari GitHub. Pastikan repositori publik.");
}

file_put_contents($zipFile, $zipData);
echo "- Berhasil mengunduh.<br><br>";

// 2. Extract ZIP
echo "2. Mengekstrak dan menimpa file lama...<br>";
$zip = new ZipArchive;
if ($zip->open($zipFile) === TRUE) {
    if (!is_dir($extractPath)) {
        mkdir($extractPath, 0755, true);
    }
    
    $zip->extractTo($extractPath);
    $zip->close();
    echo "- Ekstrak berhasil.<br>";
    
    // 3. Pindahkan file
    $sourceDir = $extractPath . '/lktech-main';
    if (is_dir($sourceDir)) {
        $baseDir = realpath(__DIR__ . '/../');
        
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($sourceDir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($iterator as $item) {
            $subPath = $iterator->getSubPathname();
            $target = $baseDir . '/' . $subPath;
            
            if ($item->isDir()) {
                if (!is_dir($target)) {
                    mkdir($target, 0755, true);
                }
            } else {
                copy($item, $target);
            }
        }
        echo "- File berhasil disalin ke sistem.<br><br>";
        
        // 4. Bersihkan file sampah
        function rrmdir($dir) {
            if (is_dir($dir)) {
                $objects = scandir($dir);
                foreach ($objects as $object) {
                    if ($object != "." && $object != "..") {
                        if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
                            rrmdir($dir. DIRECTORY_SEPARATOR .$object);
                        else
                            unlink($dir. DIRECTORY_SEPARATOR .$object);
                    }
                }
                rmdir($dir);
            }
        }
        
        rrmdir($extractPath);
        unlink($zipFile);
        echo "3. File sementara berhasil dibersihkan.<br><br>";
        
        // 5. Jalankan optimasi Laravel (Clear Cache & Migrate)
        echo "4. Menjalankan Optimasi & Migrasi Database...<br>";
        require __DIR__.'/../vendor/autoload.php';
        $app = require_once __DIR__.'/../bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
        $kernel->handle(Illuminate\Http\Request::capture());
        
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        echo "- Cache berhasil dibersihkan.<br>";
        
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        echo "- Migrasi database berhasil dijalankan.<br><br>";
        
        echo "<h3 style='color:green;'>✅ DEPLOYMENT SUKSES!</h3>";
        echo "Website LKTech Anda sudah menggunakan kode versi terbaru. Silakan kembali ke halaman utama.";
        
    } else {
        echo "<b>Error:</b> Folder lktech-main tidak ditemukan dalam ZIP.";
    }
} else {
    echo "<b>Error:</b> Gagal membuka file ZIP.";
}
