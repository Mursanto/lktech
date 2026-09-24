<?php
/**
 * TEMPORARY CACHE CLEAR SCRIPT
 * Gunakan SEKALI di hosting, lalu HAPUS FILE INI untuk keamanan!
 * 
 * Akses via: https://lktech.online/clear_cache_temp.php
 */

// Simple security check
$secret = $_GET['key'] ?? '';
if ($secret !== 'lktech2026clear') {
    http_response_code(403);
    die('403 Forbidden - Provide key parameter');
}

define('LARAVEL_ROOT', __DIR__ . '/../');

$results = [];

// 1. Clear compiled views
$viewCachePath = LARAVEL_ROOT . 'storage/framework/views/';
if (is_dir($viewCachePath)) {
    $files = glob($viewCachePath . '*.php');
    $count = 0;
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
            $count++;
        }
    }
    $results[] = "✅ View cache cleared: {$count} file(s) dihapus";
} else {
    $results[] = "⚠️ View cache path tidak ditemukan: {$viewCachePath}";
}

// 2. Clear config cache
$configCache = LARAVEL_ROOT . 'bootstrap/cache/config.php';
if (file_exists($configCache)) {
    unlink($configCache);
    $results[] = "✅ Config cache cleared";
} else {
    $results[] = "ℹ️ Config cache tidak ada (normal)";
}

// 3. Clear route cache
$routeCache = LARAVEL_ROOT . 'bootstrap/cache/routes-v7.php';
if (file_exists($routeCache)) {
    unlink($routeCache);
    $results[] = "✅ Route cache cleared";
} else {
    // Try other route cache filenames
    $routeCaches = glob(LARAVEL_ROOT . 'bootstrap/cache/routes*.php');
    foreach ($routeCaches as $rc) {
        unlink($rc);
        $results[] = "✅ Route cache cleared: " . basename($rc);
    }
    if (empty($routeCaches)) {
        $results[] = "ℹ️ Route cache tidak ada (normal)";
    }
}

// 4. Clear events cache
$eventsCache = LARAVEL_ROOT . 'bootstrap/cache/events.php';
if (file_exists($eventsCache)) {
    unlink($eventsCache);
    $results[] = "✅ Events cache cleared";
}

// Output hasil
?>
<!DOCTYPE html>
<html>
<head>
    <title>LKTech - Clear Cache</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .box { background: white; padding: 20px; border-radius: 8px; max-width: 600px; margin: 0 auto; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #1d4ed8; }
        ul li { padding: 5px 0; font-size: 14px; }
        .warning { background: #fef3c7; border: 1px solid #f59e0b; padding: 10px; border-radius: 5px; margin-top: 15px; font-size: 13px; }
    </style>
</head>
<body>
    <div class="box">
        <h1>🧹 Cache Cleared</h1>
        <ul>
            <?php foreach ($results as $r): ?>
                <li><?= htmlspecialchars($r) ?></li>
            <?php endforeach; ?>
        </ul>
        <div class="warning">
            ⚠️ <strong>PENTING:</strong> Segera hapus file <code>clear_cache_temp.php</code> dari server setelah selesai digunakan!
        </div>
    </div>
</body>
</html>
