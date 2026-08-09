<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return view('orders.index');
    }

    public function getGuestOrders(Request $request)
    {
        $query = Sale::with(['saleDetails.product', 'customer']);

        if ($request->has('search_query')) {
            $search = $request->input('search_query');
            $query->where('payment_reference_id', $search)
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('phone', 'like', '%' . $search . '%');
                  });
        } elseif ($request->has('references') && is_array($request->input('references'))) {
            $references = $request->input('references');
            $query->whereIn('payment_reference_id', $references);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Invalid parameters'], 400);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        $formattedOrders = $orders->map(function ($order) {
            $details = $order->saleDetails->map(function ($detail) {
                return [
                    'product_name' => ($detail->product->brand ?? '') . ' ' . ($detail->product->model_series ?? 'Produk'),
                    'quantity' => $detail->quantity,
                    'price_formatted' => number_format($detail->price_at_transaction, 0, ',', '.'),
                    'image_url' => $detail->product && $detail->product->image_path ? \Illuminate\Support\Facades\Storage::url($detail->product->image_path) : null,
                ];
            });

            return [
                'id' => $order->id,
                'reference_number' => $order->payment_reference_id ?? 'SALE-' . $order->id,
                'created_at_formatted' => $order->created_at->format('d M Y, H:i'),
                'order_status' => $order->order_status,
                'payment_status' => $order->payment_status,
                'total_amount' => $order->total_amount,
                'total_formatted' => number_format($order->total_amount, 0, ',', '.'),
                'details' => $details,
                'details_count' => $order->saleDetails->count(),
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $formattedOrders
        ]);
    }

    public function checkStatus($id)
    {
        $sale = Sale::find($id);
        
        if (!$sale) {
            return response()->json(['status' => 'not_found'], 404);
        }

        // Returns 'success' (Lunas), 'pending', 'failed'
        return response()->json([
            'status' => $sale->payment_status === 'success' ? 'paid' : $sale->payment_status,
            'payment_status' => $sale->payment_status
        ]);
    }

    public function cancelOrder(Request $request, $id)
    {
        $sale = Sale::with('saleDetails.product')->findOrFail($id);

        $userOrderIds = session()->get('user_orders', []);
        
        // Cek otorisasi
        if (!in_array($sale->id, $userOrderIds)) {
            abort(403, 'Unauthorized action.');
        }

        if ($sale->payment_status !== 'pending') {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }

        // 1. Ubah status pesanan menjadi dibatalkan
        $sale->payment_status = 'failed'; 
        $sale->save();

        // 2. Kembalikan stok produk jika saat checkout stok berkurang
        foreach ($sale->saleDetails as $item) {
            if ($item->product) {
                $item->product->increment('stock', $item->quantity);
            }
        }

        return redirect()->route('katalog.index')->with('success', 'Pesanan berhasil dibatalkan dan stok telah dikembalikan.');
    }
}
