<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $query = Rental::with(['customer', 'product']);

        $query->when($request->search, function ($q) use ($request) {
            $search = trim($request->search);
            $q->where(function ($sub) use ($search) {
                $sub->where('customer_name', 'LIKE', "%{$search}%")
                    ->orWhere('laptop_name', 'LIKE', "%{$search}%")
                    ->orWhereHas('customer', function ($cust) use ($search) {
                        $cust->where('name', 'LIKE', "%{$search}%");
                    });
            });
        });

        $query->when($request->date, function ($q) use ($request) {
            $q->whereDate('rental_date', $request->date);
        });

        $query->when($request->payment_method, function ($q) use ($request) {
            $q->where('payment_method', $request->payment_method);
        });

        $query->when($request->status, function ($q) use ($request) {
            $q->where('payment_status', $request->status);
        });

        $rentals = $query->latest()->paginate(10)->appends($request->all());
        return view('rentals.index', compact('rentals'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $products  = Product::where('stock', '>', 0)
            ->whereHas('category', function($q) {
                $q->where('type_category', 'hardware');
            })->get();

        // Flat list untuk JS fast-search dropdown
        $productsJson = $products->map(fn($p) => [
            'id'    => $p->id,
            'text'  => ($p->brand ?? '') . ' ' . ($p->model_series ?? '') . ' — SN: ' . ($p->serial_number ?? 'N/A') . ' (Stok: ' . $p->stock . ')',
            'price' => (float)($p->selling_price ?? 0),
            'stock' => (int)$p->stock,
            'name'  => trim(($p->brand ?? '') . ' ' . ($p->model_series ?? '')),
            'sn'    => $p->serial_number ?? 'N/A',
        ]);

        return view('rentals.create', compact('customers', 'products', 'productsJson'));
    }

    public function store(Request $request)
    {
        $isNewCustomer = $request->has('is_new_customer') && $request->is_new_customer == '1';

        $rules = [
            'product_id'  => 'required|exists:products,id',
            'rental_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:rental_date',
            'daily_price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'status'      => 'required|in:active,completed,overdue,cancelled',
            'payment_status' => 'nullable|in:pending,success,failed,cancelled',
            'payment_method' => 'nullable|string|max:50',
            'notes'       => 'nullable|string',
            'manual_sn'   => 'nullable|string',
        ];

        if ($isNewCustomer) {
            $rules['new_customer_name']    = 'required|string|max:255';
            $rules['new_customer_phone']   = 'required|string|max:20';
            $rules['new_customer_address'] = 'nullable|string';
        } else {
            $rules['customer_id'] = 'required|exists:customers,id';
        }

        $request->validate($rules);

        $product = Product::findOrFail($request->product_id);
        if ($product->stock <= 0) {
            return back()->withInput()->withErrors(['product_id' => 'Stok unit ini tidak tersedia.']);
        }

        // Buat atau ambil pelanggan
        if ($isNewCustomer) {
            $customer = Customer::create([
                'name'    => $request->new_customer_name,
                'phone'   => $request->new_customer_phone,
                'address' => $request->new_customer_address,
            ]);
        } else {
            $customer = Customer::findOrFail($request->customer_id);
        }

        // Kurangi stok
        $product->decrement('stock');
        if ($product->stock == 0) {
            $product->update(['status' => 'rented']);
        }

        Rental::create([
            'customer_id'    => $customer->id,
            'customer_name'  => $customer->name,
            'customer_phone' => $customer->phone,
            'laptop_name'    => trim($product->brand . ' ' . $product->model_series),
            'serial_number'  => $product->serial_number,
            'rental_date'    => $request->rental_date,
            'return_date'    => $request->return_date,
            'daily_price'    => $request->daily_price,
            'total_price'    => $request->total_price,
            'status'         => $request->status,
            'payment_status' => $request->payment_status ?? 'pending',
            'payment_method' => $request->payment_method ?? 'Cash',
            'notes'          => $request->notes,
            'manual_sn'      => $request->manual_sn,
        ]);

        return redirect()->route('rentals.index')
            ->with('success', 'Data sewa laptop berhasil ditambahkan.');
    }

    public function show(Rental $rental)
    {
        $rental->load('customer');
        return view('rentals.show', compact('rental'));
    }

    public function edit(Rental $rental)
    {
        $customers = Customer::orderBy('name')->get();
        $products  = Product::where('stock', '>', 0)
            ->whereHas('category', function($q) {
                $q->where('type_category', 'hardware');
            })->get();
        return view('rentals.edit', compact('rental', 'customers', 'products'));
    }

    public function update(Request $request, Rental $rental)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'laptop_name'    => 'required|string|max:255',
            'serial_number'  => 'nullable|string|max:255',
            'rental_date'    => 'required|date',
            'return_date'    => 'required|date|after_or_equal:rental_date',
            'daily_price'    => 'nullable|numeric|min:0',
            'total_price'    => 'required|numeric|min:0',
            'status'         => 'required|in:active,completed,overdue,cancelled',
            'payment_status' => 'nullable|in:pending,success,failed,cancelled',
            'payment_method' => 'nullable|string|max:50',
            'notes'          => 'nullable|string',
            'manual_sn'      => 'nullable|string',
        ]);

        $oldStatus = $rental->status;

        // Sync customer data if customer_id is provided
        if ($request->filled('customer_id')) {
            $customer = Customer::find($request->customer_id);
            if ($customer) {
                $request->merge([
                    'customer_name'  => $customer->name,
                    'customer_phone' => $customer->phone,
                ]);
            }
        }

        $rental->update($request->only([
            'customer_id', 'customer_name', 'customer_phone',
            'laptop_name', 'serial_number',
            'rental_date', 'return_date', 'daily_price', 'total_price',
            'status', 'notes', 'manual_sn', 'payment_status', 'payment_method',
        ]));

        // Kembalikan stok jika status berubah menjadi selesai
        if ($oldStatus !== 'completed' && $rental->status === 'completed') {
            $product = $rental->serial_number
                ? Product::where('serial_number', $rental->serial_number)->first()
                : Product::whereRaw("CONCAT(brand, ' ', model_series) LIKE ?", ['%' . trim($rental->laptop_name) . '%'])->first();

            if ($product) {
                $product->increment('stock');
                $product->update(['status' => 'available']);
            }
        }

        return redirect()->route('rentals.index')
            ->with('success', 'Data sewa laptop berhasil diperbarui.');
    }

    public function destroy(Rental $rental)
    {
        $rental->delete();
        return redirect()->route('rentals.index')
            ->with('success', 'Data sewa laptop berhasil dihapus.');
    }

    /**
     * Cancel an active rental and restore stock.
     */
    public function cancel(Rental $rental)
    {
        if (in_array($rental->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'Penyewaan yang sudah selesai atau batal tidak dapat dibatalkan.');
        }

        try {
            $rental->update(['status' => 'cancelled']);

            // Restore stock
            $product = $rental->serial_number
                ? Product::where('serial_number', $rental->serial_number)->first()
                : Product::whereRaw("CONCAT(brand, ' ', model_series) LIKE ?", ['%' . trim($rental->laptop_name) . '%'])->first();

            if ($product) {
                $product->increment('stock');
                if ($product->stock > 0 && $product->status === 'rented') {
                    $product->update(['status' => 'available']);
                }
            }

            return back()->with('success', 'Data sewa laptop berhasil dibatalkan dan stok telah dikembalikan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membatalkan penyewaan: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\RentalsExport, 'sewa_laptop.xlsx');
    }
}
