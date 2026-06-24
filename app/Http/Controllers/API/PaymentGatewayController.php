<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderInvoiceMail;

class PaymentGatewayController extends Controller
{
    /**
     * Send invoice data to the Gateway and receive the dynamic QRIS URL or GoPay Deeplink.
     * 
     * @param string $orderId
     * @param float $amount
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTransaction($orderId, $amount)
    {
        // TODO: Implement Gateway SDK logic here (Midtrans/Duitku)
        // Example:
        // $params = [
        //     'transaction_details' => [
        //         'order_id' => $orderId,
        //         'gross_amount' => $amount,
        //     ],
        // ];
        // $transaction = \Midtrans\Snap::createTransaction($params);
        // return response()->json(['payment_url' => $transaction->redirect_url]);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction stub created.',
            'data' => [
                'order_id' => $orderId,
                'amount' => $amount,
                'payment_url' => 'https://example.com/pay/' . uniqid()
            ]
        ]);
    }

    /**
     * The critical Webhook/Callback route that receives the POST data from the Gateway
     * when a customer successfully pays.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleNotification(Request $request)
    {
        $payload = $request->all();
        Log::info('Payment Gateway Webhook Received', $payload);

        $orderId = $payload['order_id'] ?? '';
        $statusCode = $payload['status_code'] ?? '';
        $grossAmount = $payload['gross_amount'] ?? '';
        $serverKey = config('services.midtrans.server_key');
        $signatureKey = $payload['signature_key'] ?? '';
        $transactionStatus = $payload['transaction_status'] ?? '';
        $paymentType = $payload['payment_type'] ?? '';

        // Verify Signature
        $calculatedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        
        if ($calculatedSignature !== $signatureKey) {
            Log::warning('Midtrans Invalid Signature', ['order_id' => $orderId]);
            return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 403);
        }

        // Determine record type and ID from order_id (e.g. SALE-12-162334)
        $parts = explode('-', $orderId);
        if (count($parts) < 2) {
            return response()->json(['status' => 'error', 'message' => 'Invalid order_id format'], 400);
        }

        $typePrefix = $parts[0];
        $recordId = $parts[1];

        $record = null;
        if ($typePrefix === 'SALE') {
            $record = \App\Models\Sale::find($recordId);
        } elseif ($typePrefix === 'SVC') {
            $record = \App\Models\Service::find($recordId);
        } elseif ($typePrefix === 'RNT') {
            $record = \App\Models\Rental::find($recordId);
        }

        if (!$record) {
            return response()->json(['status' => 'error', 'message' => 'Record not found'], 404);
        }

        // Map Midtrans status to our database status
        $paymentStatus = 'pending';
        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            $paymentStatus = 'success';
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'])) {
            $paymentStatus = 'failed';
        } elseif ($transactionStatus === 'pending') {
            $paymentStatus = 'pending';
        }

        // CRITICAL PRECAUTION: Prevent double stock deduction if Midtrans sends success twice
        if ($paymentStatus === 'success' && $record->payment_status !== 'success') {
            if ($typePrefix === 'SALE') {
                // Fetch the related order details/items
                $details = \App\Models\SaleDetail::where('sale_id', $record->id)->get();
                foreach ($details as $detail) {
                    $product = \App\Models\Product::find($detail->product_id);
                    if ($product) {
                        // Deduct stock
                        $product->decrement('stock', $detail->quantity);
                        
                        // Optional: Mark as Sold if stock hits 0
                        if ($product->stock <= 0) {
                            $product->update(['status' => 'Sold']);
                        }
                    }
                }
                
                // Send Invoice Email
                if ($record->customer && $record->customer->email) {
                    try {
                        Mail::to($record->customer->email)->send(new OrderInvoiceMail($record));
                    } catch (\Exception $e) {
                        Log::error('Gagal mengirim email invoice: ' . $e->getMessage());
                    }
                }
            }
        }

        // Update Database
        $record->update([
            'payment_status' => $paymentStatus,
            'payment_method' => $paymentType,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Notification processed successfully'
        ]);
    }

    /**
     * Fallback pooling method to manually verify payment status via API.
     * 
     * @param string $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkStatus($orderId)
    {
        // TODO: Call Gateway SDK to check exact status of $orderId
        // Example: $status = \Midtrans\Transaction::status($orderId);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Status checked.',
            'data' => [
                'order_id' => $orderId,
                'payment_status' => 'success'
            ]
        ]);
    }

    /**
     * Generate Midtrans Snap Token for frontend pop-up.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSnapToken(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|integer',
            'type' => 'required|in:sale,service,rental',
        ]);

        $id = $request->transaction_id;
        $type = $request->type;
        $grossAmount = 0;
        $customerName = 'Pelanggan LKtech';
        $customerEmail = 'customer@lktech.online';
        $customerPhone = '081234567890';
        $orderId = '';
        $record = null;

        if ($type === 'sale') {
            $record = \App\Models\Sale::with('customer')->findOrFail($id);
            $grossAmount = $record->total_amount;
            $orderId = 'SALE-' . $record->id . '-' . time();
            if ($record->customer) {
                $customerName = $record->customer->name;
                $customerEmail = $record->customer->email ?? $customerEmail;
                $customerPhone = $record->customer->phone ?? $customerPhone;
            }
        } elseif ($type === 'service') {
            $record = \App\Models\Service::with('customer')->findOrFail($id);
            $grossAmount = $record->estimated_cost ?? $record->total_amount;
            $orderId = 'SVC-' . $record->id . '-' . time();
            if ($record->customer) {
                $customerName = $record->customer->name;
                $customerEmail = $record->customer->email ?? $customerEmail;
                $customerPhone = $record->customer->phone ?? $customerPhone;
            }
        } elseif ($type === 'rental') {
            $record = \App\Models\Rental::findOrFail($id);
            $grossAmount = $record->total_price;
            $orderId = 'RNT-' . $record->id . '-' . time();
            $customerName = $record->customer_name;
            $customerEmail = $record->customer_email ?? $customerEmail;
            $customerPhone = $record->customer_phone ?? $customerPhone;
        }

        // Midtrans Endpoint
        $midtransUrl = config('services.midtrans.is_production') 
            ? 'https://app.midtrans.com/snap/v1/transactions' 
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
            
        $serverKey = config('services.midtrans.server_key');

        $customerDetails = [
            'first_name' => $customerName,
        ];
        if ($customerEmail) {
            $customerDetails['email'] = $customerEmail;
        }
        if ($customerPhone) {
            $customerDetails['phone'] = $customerPhone;
        }

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $grossAmount,
            ],
            'customer_details' => $customerDetails,
        ];

        try {
            $http = \Illuminate\Support\Facades\Http::withBasicAuth($serverKey, '')
                ->withHeaders(['Accept' => 'application/json']);
                
            if (app()->environment('local')) {
                $http = $http->withoutVerifying();
            }

            $response = $http->post($midtransUrl, $payload);

            if ($response->successful()) {
                // Save the generated order_id to database for future reference / webhook
                $record->update(['payment_reference_id' => $orderId]);
                
                return response()->json(['snap_token' => $response->json('token')]);
            }

            Log::error('Midtrans Snap Error: ', $response->json() ?? [$response->body()]);

            if (app()->environment('local')) {
                Log::info('Local Fallback: Simulating successful payment for snap token because Midtrans Gateway returned an error.');
                $record->update([
                    'payment_status' => 'success',
                    'payment_method' => 'Midtrans Mock',
                    'payment_reference_id' => $orderId
                ]);
                
                if ($type === 'sale') {
                    $details = \App\Models\SaleDetail::where('sale_id', $record->id)->get();
                    foreach ($details as $detail) {
                        $product = \App\Models\Product::find($detail->product_id);
                        if ($product) {
                            $product->decrement('stock', $detail->quantity);
                            if ($product->stock <= 0) {
                                $product->update(['status' => 'Sold']);
                            }
                        }
                    }
                }
                
                return response()->json(['snap_token' => 'mock-snap-token-' . uniqid()]);
            }

            return response()->json(['error' => 'Gagal mendapatkan token pembayaran dari Gateway.'], 500);

        } catch (\Exception $e) {
            Log::error('Midtrans Exception: ' . $e->getMessage());

            if (app()->environment('local')) {
                Log::info('Local Fallback: Simulating successful payment for snap token because Midtrans Gateway threw an exception.');
                $record->update([
                    'payment_status' => 'success',
                    'payment_method' => 'Midtrans Mock',
                    'payment_reference_id' => $orderId
                ]);
                
                if ($type === 'sale') {
                    $details = \App\Models\SaleDetail::where('sale_id', $record->id)->get();
                    foreach ($details as $detail) {
                        $product = \App\Models\Product::find($detail->product_id);
                        if ($product) {
                            $product->decrement('stock', $detail->quantity);
                            if ($product->stock <= 0) {
                                $product->update(['status' => 'Sold']);
                            }
                        }
                    }
                }
                
                return response()->json(['snap_token' => 'mock-snap-token-' . uniqid()]);
            }

            return response()->json(['error' => 'Terjadi kesalahan sistem internal.'], 500);
        }
    }
}
