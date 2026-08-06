<?php
/**
 * One-Time Deploy Sync Script for LKTech
 * 
 * SECURITY: DELETE THIS FILE FROM SERVER AFTER USE!
 * Access: https://lktech.online/deploy_sync.php?token=lktech_deploy_2024
 */

$token = $_GET['token'] ?? '';
$validToken = 'lktech_deploy_2024';

if ($token !== $validToken) {
    http_response_code(403);
    die('<h2 style="color:red">403 Forbidden — Invalid or missing token.</h2>');
}

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$results = [];

// 1. Rename Categories in DB
$renames = [
    'Unit Device'         => 'Laptop & Device',
    'Sparepart / Komponen' => 'Komponen & Sparepart',
    'Software / Digital'  => 'Lisensi & Software',
];

foreach ($renames as $old => $new) {
    try {
        $affected = \App\Models\Category::where('name', $old)->update(['name' => $new]);
        $results[] = ['status' => 'ok', 'msg' => "Category: \"$old\" → \"$new\" ($affected rows updated)"];
    } catch (\Exception $e) {
        $results[] = ['status' => 'error', 'msg' => "Category rename error: " . $e->getMessage()];
    }
}

// 2. Artisan Cache Clear commands
$commands = [
    'view:clear'      => 'Clear compiled views',
    'cache:clear'     => 'Clear application cache',
    'config:clear'    => 'Clear config cache',
    'route:clear'     => 'Clear route cache',
    'optimize:clear'  => 'Clear all optimizations',
];

foreach ($commands as $cmd => $label) {
    try {
        \Illuminate\Support\Facades\Artisan::call($cmd);
        $output = \Illuminate\Support\Facades\Artisan::output();
        $results[] = ['status' => 'ok', 'msg' => "[$label] php artisan $cmd → " . trim($output ?: 'Done')];
    } catch (\Exception $e) {
        $results[] = ['status' => 'error', 'msg' => "[$label] Error: " . $e->getMessage()];
    }
}

// Display results
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>LKTech Deploy Sync</title>
<style>
body { font-family: monospace; background: #1a1a2e; color: #e0e0e0; padding: 30px; }
h1 { color: #00d4ff; }
.ok { color: #00ff88; }
.error { color: #ff4455; }
.warning { background: #ff4455; color: white; padding: 10px 16px; border-radius: 6px; margin-top: 20px; font-size: 14px; font-weight: bold; }
li { margin: 6px 0; }
</style>
</head>
<body>
<h1>🚀 LKTech Deploy Sync — Results</h1>
<ul>
<?php foreach ($results as $r): ?>
    <li class="<?= $r['status'] ?>">
        <?= $r['status'] === 'ok' ? '✅' : '❌' ?> <?= htmlspecialchars($r['msg']) ?>
    </li>
<?php endforeach; ?>
</ul>
<div class="warning">⚠️ IMPORTANT: DELETE THIS FILE FROM THE SERVER IMMEDIATELY AFTER USE! <br>Run: <code>rm /home/cfsw7633/public_html/lktech.online/public/deploy_sync.php</code></div>
</body>
</html>
