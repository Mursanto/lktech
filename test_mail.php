<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $sale = \App\Models\Sale::find(66);
    \Illuminate\Support\Facades\Mail::to('mursanto@telkomsat.co.id')->send(new \App\Mail\OrderInvoiceMail($sale));
    echo "SUCCESS: OrderInvoiceMail sent successfully.\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
