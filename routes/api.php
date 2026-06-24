<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PaymentGatewayController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Payment Gateway Callback Route (Exempted from CSRF in bootstrap/app.php)
Route::post('/payment/callback', [PaymentGatewayController::class, 'handleNotification'])->name('payment.callback');

// Endpoint to generate Snap Token
Route::post('/payment/snap-token', [PaymentGatewayController::class, 'getSnapToken'])->name('payment.snap_token');
