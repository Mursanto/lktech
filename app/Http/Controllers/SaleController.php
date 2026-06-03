<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\ActivityLog;
use App\Models\Customer;
use App\Exports\SalesExport;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Excel;

class SaleController extends Controller
{
    /**
     * Display a listing of sales.
     */
    public function index(Request $request)
    {
        $query = Sale::with(['customer', 'user', 'saleDetails.product']);

        $query->when($request->search, function ($q) use ($request) {
            $search = trim($request->search);
            $idSearch = $search;
            
            // Bersihkan format invoice seperti #INV-000019 atau #000019 menjadi 19
            if (preg_match('/^#?INV-0*(\d+)$/i', $search, $matches)) {
                $idSearch = $matches[1];
            } elseif (preg_match('/^#?0*(\d+)$/i', $search, $matches)) {
                $idSearch = $matches[1];
            }

            $q->where(function($q) use ($search, $idSearch) {
                $q->where('id', 'LIKE', "%{$idSearch}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  });
            });
        });

        $query->when($request->payment_method, function ($q) use ($request) {
            $q->where('payment_method', $request->payment_method);
        });

        $sales = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->all());
            
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new sale.
     */
    public function create()
    {
        $customers = \App\Models\Customer::all();

        // Ambil produk dengan status available, dikelompokkan berdasarkan kategori
        $groupedProducts = \App\Models\Product::with('category')
            ->where('status', 'available')
            ->get()
            ->groupBy(function($data) {
                return $data->category->name ?? 'Lainnya';
            });

        // Flat list untuk JS PRODUCTS constant (hindari query kompleks di dalam @json Blade)
        $productsJson = \App\Models\Product::with('category')
            ->where('status', 'available')
            ->get()
            ->map(fn($p) => [
                'id'       => $p->id,
                'text'     => ($p->brand ?? '') . ' ' . ($p->model_series ?? '') . ' — ' . ($p->serial_number ?? 'N/A') . ' (Stok: ' . $p->stock . ')',
                'price'    => (float)($p->selling_price ?? 0),
                'stock'    => (int)$p->stock,
                'category' => $p->category->name ?? 'Lainnya',
                'type_category' => $p->category->type_category ?? 'hardware',
                'sn'       => $p->serial_number ?? '',
            ])->values()->toArray();

        return view('sales.create', compact('customers', 'groupedProducts', 'productsJson'));
    }


    /**
     * Store a newly created sale in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            $sale = \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
                // 1. Tentukan ID Pelanggan
                $customerId = null;
                if ($request->is_new_customer == '1') {
                    $customer = \App\Models\Customer::firstOrCreate(
                        ['phone' => $request->new_customer_phone],
                        ['name' => $request->new_customer_name, 'email' => $request->new_customer_email, 'address' => $request->new_customer_address ?? '']
                    );
                    $customerId = $customer->id;
                } elseif ($request->filled('customer_id')) {
                    $customerId = $request->customer_id;
                }

                // 2. Buat "Faktur Induk" (Tabel Sales) DULU dengan nilai 0
                // Ingat: Tabel sales TIDAK punya kolom quantity dan product_id
                $sale = \App\Models\Sale::create([
                    'customer_id' => $customerId,
                    'total_amount' => 0,
                    'profit_amount' => 0,
                    'user_id' => auth()->id() ?? 1,
                    'transaction_date' => now(),
                    'payment_method' => $request->input('payment_method', 'cash'),
                    'notes' => $request->input('notes')
                ]);

                $grandTotal = 0;
                $totalProfit = 0;

                // 3. Loop Item: Potong Stok & Simpan ke Tabel Anak (SaleDetail)
                foreach ($request->items as $item) {
                    $product = \App\Models\Product::lockForUpdate()->findOrFail($item['product_id']);
                    
                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Stok {$product->brand} tidak mencukupi! Sisa: {$product->stock}");
                    }

                    // Verifikasi SN untuk kategori hardware
                    if ($product->category && $product->category->type_category === 'hardware') {
                        $inputSn = $item['serial_number'] ?? null;
                        if (!$inputSn || trim($inputSn) !== trim($product->serial_number)) {
                            throw new \Exception("Verifikasi Serial Number untuk {$product->brand} {$product->model_series} gagal! SN yang dimasukkan tidak cocok.");
                        }
                    }

                    $subtotal = $product->selling_price * $item['quantity'];
                    $profit = ($product->selling_price - $product->purchase_price) * $item['quantity']; 
                    
                    $grandTotal += $subtotal;
                    $totalProfit += $profit;

                    // Simpan Rincian ke SaleDetail (NAMA KOLOM SUDAH DISESUAIKAN)
                    \App\Models\SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price_at_transaction' => $product->selling_price,
                        'purchase_price' => $product->purchase_price ?? 0,
                        'profit' => $profit,
                        'manual_sn' => $item['manual_sn'] ?? null
                    ]);

                    // Potong stok gudang
                    $product->stock -= $item['quantity'];
                    if ($product->stock <= 0) {
                        $product->stock = 0;
                        $product->status = 'sold';
                    }
                    $product->save();
                }

                // 4. Update Faktur Induk dengan Total Harga & Laba yang sebenarnya
                $sale->update([
                    'total_amount' => $grandTotal,
                    'profit_amount' => $totalProfit
                ]);

                return $sale; // <--- WAJIB TAMBAHKAN INI DI AKHIR TRANSAKSI
            });

            return redirect()->route('sales.show', $sale->id)->with('success', 'Penjualan sukses disimpan!');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified sale.
     */
    public function show(Sale $sale)
    {
        $sale->load(['user', 'saleDetails.product.category']);
        
        return view('sales.show', compact('sale'));
    }

    /**
     * Generate PDF invoice for the sale.
     */
    public function generateInvoice(Sale $sale)
    {
        $sale->load(['user', 'saleDetails.product.category']);
        
        $data = [
            'sale' => $sale,
            'company' => [
                'name' => 'LKTECH',
                'address' => 'Jl. Teknologi No. 123, Jakarta, Indonesia',
                'phone' => '+62 21 1234 5678',
                'email' => 'info@lktech.com',
            ],
            'warranty_terms' => [
                'Garansi 1 tahun untuk kerusakan hardware (bukan karena human error)',
                'Garansi tidak berlaku untuk kerusakan akibat jatuh, air, atau modifikasi',
                'Service garansi hanya berlaku di service center resmi LKTECH',
                'Baterai dan charger garansi 6 bulan',
                'Software dan driver tidak termasuk dalam garansi',
            ],
        ];

        $pdf = Pdf::loadView('sales.invoice', $data);
        
        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');
        
        // Download the PDF with a formatted filename
        $filename = 'Invoice-LKTECH-' . str_pad($sale->id, 6, '0', STR_PAD_LEFT) . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Show the form for editing the specified sale.
     */
    public function edit(Sale $sale)
    {
        $sale->load(['customer', 'saleDetails.product']);
        $customers = \App\Models\Customer::orderBy('name')->get();
        
        // Ambil produk (termasuk yang sudah habis tapi ada di transaksi ini)
        $products = \App\Models\Product::with('category')
            ->where('status', 'available')
            ->orWhereIn('id', $sale->saleDetails->pluck('product_id'))
            ->get();
        
        $groupedProducts = $products->groupBy(function($data) {
            return $data->category->name ?? 'Lainnya';
        });


        $productsJson = $products->map(fn($p) => [
            'id'       => $p->id,
            'text'     => ($p->brand ?? '') . ' ' . ($p->model_series ?? '') . ' — ' . ($p->serial_number ?? 'N/A') . ' (Stok: ' . $p->stock . ')',
            'price'    => (float)($p->selling_price ?? 0),
            'stock'    => (int)$p->stock,
            'category' => $p->category->name ?? 'Lainnya',
            'type_category' => $p->category->type_category ?? 'hardware',
            'sn'       => $p->serial_number ?? '',
        ])->values()->toArray();

        return view('sales.edit', compact('sale', 'customers', 'groupedProducts', 'productsJson'));
    }

    /**
     * Update the specified sale in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required',
        ]);

        try {
            DB::transaction(function () use ($request, $sale) {
                // 1. Kembalikan stok item lama
                foreach ($sale->saleDetails as $oldDetail) {
                    $product = Product::find($oldDetail->product_id);
                    if ($product) {
                        $product->increment('stock', $oldDetail->quantity);
                        if ($product->stock > 0) {
                            $product->status = 'available';
                        }
                        $product->save();
                    }
                }

                // 2. Hapus detail lama
                $sale->saleDetails()->delete();

                // 3. Update Identitas Pelanggan (jika ada)
                $customerId = $sale->customer_id;
                if ($request->is_new_customer == '1') {
                    $customer = Customer::create([
                        'name' => $request->new_customer_name,
                        'phone' => $request->new_customer_phone,
                        'email' => $request->new_customer_email,
                        'address' => $request->new_customer_address ?? ''
                    ]);
                    $customerId = $customer->id;
                } elseif ($request->filled('customer_id')) {
                    $customerId = $request->customer_id;
                }

                $grandTotal = 0;
                $totalProfit = 0;

                // 4. Simpan Item Baru & Potong Stok Baru
                foreach ($request->items as $item) {
                    $product = Product::lockForUpdate()->findOrFail($item['product_id']);
                    
                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Stok {$product->brand} tidak mencukupi! Sisa: {$product->stock}");
                    }

                    // Verifikasi SN untuk kategori hardware
                    if ($product->category && $product->category->type_category === 'hardware') {
                        $inputSn = $item['serial_number'] ?? null;
                        if (!$inputSn || trim($inputSn) !== trim($product->serial_number)) {
                            throw new \Exception("Verifikasi Serial Number untuk {$product->brand} {$product->model_series} gagal! SN yang dimasukkan tidak cocok.");
                        }
                    }

                    $subtotal = $product->selling_price * $item['quantity'];
                    $profit = ($product->selling_price - ($product->purchase_price ?? 0)) * $item['quantity']; 
                    
                    $grandTotal += $subtotal;
                    $totalProfit += $profit;

                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price_at_transaction' => $product->selling_price,
                        'purchase_price' => $product->purchase_price ?? 0,
                        'profit' => $profit,
                        'manual_sn' => $item['manual_sn'] ?? null
                    ]);

                    $product->decrement('stock', $item['quantity']);
                    if ($product->stock <= 0) {
                        $product->status = 'sold';
                    }
                    $product->save();
                }

                // 5. Update Faktur Induk
                $sale->update([
                    'customer_id' => $customerId,
                    'total_amount' => $grandTotal,
                    'profit_amount' => $totalProfit,
                    'payment_method' => $request->payment_method,
                    'notes' => $request->notes,
                ]);
            });

            return redirect()->route('sales.index')->with('success', 'Transaksi berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified sale from storage.
     */
    public function destroy(Sale $sale)
    {
        try {
            DB::beginTransaction();

            // Get sale details to restore product status
            $saleDetails = $sale->saleDetails;
            
            // Restore products to available status
            foreach ($saleDetails as $detail) {
                $detail->product->update(['status' => 'available']);
            }

            // Log the deletion activity
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'sale_deleted',
                'model_type' => Sale::class,
                'model_id' => $sale->id,
                'old_values' => [
                    'customer_name' => $sale->customer_name,
                    'total_amount' => $sale->total_amount,
                    'profit_amount' => $sale->profit_amount,
                ],
                'new_values' => null,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Delete sale details first
            $sale->saleDetails()->delete();
            
            // Delete sale
            $sale->delete();

            DB::commit();

            return redirect()
                ->route('sales.index')
                ->with('success', 'Sale deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'An error occurred while deleting the sale: ' . $e->getMessage()]);
        }
    }

    /**
     * Automatically recalculate profit for a sale based on current purchase prices
     */
    public function recalculateProfit(Sale $sale)
    {
        try {
            DB::beginTransaction();
            
            $originalProfit = $sale->profit_amount;
            $newTotalProfit = 0;
            
            foreach ($sale->saleDetails as $detail) {
                $product = $detail->product;
                $sellingPrice = $detail->price_at_transaction;
                $purchasePrice = $product->purchase_price;
                $calculatedProfit = $sellingPrice - $purchasePrice;
                
                // Update sale detail with correct values
                $detail->update([
                    'purchase_price' => $purchasePrice,
                    'profit' => $calculatedProfit,
                ]);
                
                $newTotalProfit += $calculatedProfit;
            }
            
            // Update sale total profit
            $sale->update([
                'profit_amount' => $newTotalProfit,
            ]);
            
            DB::commit();
            
            $profitCorrection = $newTotalProfit - $originalProfit;
            
            return response()->json([
                'success' => true,
                'message' => "Profit recalculated for Sale #{$sale->id}",
                'data' => [
                    'original_profit' => $originalProfit,
                    'new_profit' => $newTotalProfit,
                    'correction' => $profitCorrection,
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error recalculating profit: ' . $e->getMessage()
            ], 500);
        }
    }

    
    /**
     * Print the specified sale.
     */
    public function print(Sale $sale)
    {
        // Load sale with relationships
        $sale->load(['saleDetails.product', 'user']);
        
        return view('sales.print', compact('sale'));
    }

    /**
     * Download the specified sale as PDF.
     */
    public function downloadPdf(Sale $sale)
    {
        // Load sale with relationships
        $sale->load(['saleDetails.product', 'user', 'customer']);
        
        // Generate filename based on invoice number
        $filename = 'Invoice-' . str_pad($sale->id, 6, '0', STR_PAD_LEFT) . '.pdf';
        
        // Generate PDF
        $pdf = Pdf::loadView('sales.pdf', compact('sale'));
        
        // Download the PDF
        return $pdf->download($filename);
    }

    public function export()
    {
        return Excel::download(new SalesExport, 'penjualan.xlsx');
    }
}
