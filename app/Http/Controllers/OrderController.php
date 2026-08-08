<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $userOrderIds = session()->get('user_orders', []);
        
        // Include orders from logged-in user if available
        if (auth()->check()) {
            // Usually tied to customer or user_id. For now, rely on session or user_id
            $userId = auth()->id();
            // Optional: retrieve past orders by user_id if needed, but since guest is supported, session is primary
        }

        $orders = Sale::with(['saleDetails.product', 'customer'])
            ->whereIn('id', $userOrderIds)
            ->orderBy('created_at', 'desc')
            ->get();

        // Categorize
        $pendingOrders = $orders->where('order_status', 'menunggu_pembayaran');
        $processingOrders = $orders->where('order_status', 'diproses');
        $completedOrders = $orders->where('order_status', 'selesai');
        $cancelledOrders = $orders->where('order_status', 'batal');

        return view('orders.index', compact(
            'pendingOrders', 
            'processingOrders', 
            'completedOrders', 
            'cancelledOrders', 
            'orders'
        ));
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
