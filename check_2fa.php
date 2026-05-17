<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('email', 'teknisi@lktech.com')->first();
echo "Email: " . $user->email . "\n";
echo "Role: " . $user->roles->pluck('name')->join(',') . "\n";
echo "google2fa_secret: " . var_export($user->google2fa_secret, true) . "\n";
echo "otp_enabled: " . var_export($user->otp_enabled, true) . "\n";
