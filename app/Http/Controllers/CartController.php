<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderInvoiceMail;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        $cart = session()->get('cart', []);

        if ($product->image_path) {
            $display_image = \Illuminate\Support\Facades\Storage::url($product->image_path);
        } else {
            $searchQuery = urlencode($product->brand . ' ' . $product->model_series . ' laptop');
            $display_image = "https://source.unsplash.com/400x400/?{$searchQuery}";
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->brand . ' ' . $product->model_series,
                'price' => $product->selling_price,
                'purchase_price' => $product->purchase_price,
                'quantity' => 1,
                'image' => $display_image,
                'photo' => $product->image_path,
            ];
        }

        session()->put('cart', $cart);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk ditambahkan ke keranjang.',
                'cart_count' => count($cart)
            ]);
        }

        return redirect()->route('checkout.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $product = Product::find($id);
            if ($product && $request->quantity > $product->stock) {
                return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi. Sisa stok: ' . $product->stock]);
            }
            
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan di keranjang.'], 404);
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('katalog.index')->with('error', 'Keranjang Anda kosong.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('checkout.index', compact('cart', 'subtotal'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return response()->json(['error' => 'Keranjang kosong.'], 400);
        }

        $totalAmount = 0;
        $totalProfit = 0;

        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
            $profitPerItem = $item['price'] - ($item['purchase_price'] ?? 0);
            $totalProfit += $profitPerItem * $item['quantity'];
        }

        $userId = 1;

        $email = $request->email;
        $phone = $request->phone;

        $customer = \App\Models\Customer::firstOrCreate(
            ['email' => $email],
            ['name' => $request->customer_name, 'phone' => $phone]
        );
        
        // Update name and phone if it already exists but changed
        if ($customer->name !== $request->customer_name || $customer->phone !== $phone) {
            $customer->update(['name' => $request->customer_name, 'phone' => $phone]);
        }

        $sale = Sale::create([
            'user_id' => $userId,
            'customer_id' => $customer->id,
            'total_amount' => $totalAmount,
            'profit_amount' => $totalProfit,
            'transaction_date' => now(),
            'payment_status' => 'pending',
            'payment_method' => 'Transfer Manual',
        ]);

        foreach ($cart as $item) {
            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price_at_transaction' => $item['price'],
                'purchase_price' => $item['purchase_price'] ?? 0,
                'profit' => ($item['price'] - ($item['purchase_price'] ?? 0)) * $item['quantity'],
            ]);
        }

        $orderId = 'SALE-' . $sale->id . '-' . time();

        // ==========================================
        // BYPASS MIDTRANS UNTUK SEMENTARA
        // ==========================================
        Log::info('Bypass Midtrans: Meneruskan ke Manual Transfer untuk Order ID: ' . $orderId);
        
        $sale->update([
            'payment_reference_id' => $orderId
        ]);
        
        // Kirim Proforma Invoice
        if ($customer->email) {
            try {
                Mail::to($customer->email)->send(new OrderInvoiceMail($sale));
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email invoice: ' . $e->getMessage());
            }
        }
        
        return response()->json([
            'snap_token' => 'mock-bypass-' . uniqid(),
            'order_id' => $sale->id
        ]);
    }

    public function success($order_id)
    {
        session()->forget('cart');
        $sale = Sale::with(['customer', 'saleDetails.product'])->findOrFail($order_id);
        
        $paymentInfo = null;

        if ($sale->payment_status === 'pending' && $sale->payment_reference_id) {
            $serverKey = config('services.midtrans.server_key');
            $isProduction = config('services.midtrans.is_production');
            $baseUrl = $isProduction ? 'https://api.midtrans.com' : 'https://api.sandbox.midtrans.com';
            
            try {
                $response = \Illuminate\Support\Facades\Http::withBasicAuth($serverKey, '')
                    ->get("{$baseUrl}/v2/{$sale->payment_reference_id}/status");
                
                if ($response->successful()) {
                    $midtransStatus = $response->json();
                    $transactionStatus = $midtransStatus['transaction_status'] ?? 'pending';
                    
                    if (in_array($transactionStatus, ['capture', 'settlement'])) {
                        $sale->payment_status = 'success';
                        $sale->payment_method = $midtransStatus['payment_type'] ?? $sale->payment_method;
                        $sale->save();
                        
                        foreach ($sale->saleDetails as $detail) {
                            $product = $detail->product;
                            if ($product) {
                                $product->decrement('stock', $detail->quantity);
                                if ($product->stock <= 0) {
                                    $product->update(['status' => 'Sold']);
                                }
                            }
                        }
                        
                        if ($sale->customer && $sale->customer->email) {
                            try {
                                Mail::to($sale->customer->email)->send(new OrderInvoiceMail($sale));
                            } catch (\Exception $e) {
                                Log::error('Gagal mengirim email invoice: ' . $e->getMessage());
                            }
                        }
                    } elseif ($transactionStatus === 'pending') {
                        $paymentInfo = [
                            'payment_type' => $midtransStatus['payment_type'] ?? null,
                            'bank' => null,
                            'va_number' => null,
                            'biller_code' => null,
                            'bill_key' => null,
                        ];
                        
                        if (isset($midtransStatus['va_numbers']) && count($midtransStatus['va_numbers']) > 0) {
                            $paymentInfo['bank'] = strtoupper($midtransStatus['va_numbers'][0]['bank']);
                            $paymentInfo['va_number'] = $midtransStatus['va_numbers'][0]['va_number'];
                        } elseif (isset($midtransStatus['bca_va_number'])) {
                            $paymentInfo['bank'] = 'BCA';
                            $paymentInfo['va_number'] = $midtransStatus['bca_va_number'];
                        } elseif (isset($midtransStatus['permata_va_number'])) {
                            $paymentInfo['bank'] = 'PERMATA';
                            $paymentInfo['va_number'] = $midtransStatus['permata_va_number'];
                        } elseif ($paymentInfo['payment_type'] === 'echannel') {
                            $paymentInfo['bank'] = 'MANDIRI';
                            $paymentInfo['biller_code'] = $midtransStatus['biller_code'] ?? null;
                            $paymentInfo['bill_key'] = $midtransStatus['bill_key'] ?? null;
                        }
                    } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'])) {
                        $sale->payment_status = 'failed';
                        $sale->save();
                    }
                }
            } catch (\Exception $e) {
                Log::error('Failed to sync Midtrans status: ' . $e->getMessage());
            }
        }

        return view('checkout.success', compact('sale', 'paymentInfo'));
    }
}
