<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with('customer')->latest()->paginate(10);
        return view('rentals.index', compact('rentals'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $products  = Product::where('stock', '>', 0)
            ->whereHas('category', function($q) {
                $q->where('type_category', 'hardware');
            })->get();
        return view('rentals.create', compact('customers', 'products'));
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
            'status'      => 'required|in:active,completed,overdue',
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
            'status'         => 'required|in:active,completed,overdue',
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
            'status', 'notes', 'manual_sn',
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

    public function export()
    {
        return redirect()->back()->with('error', 'Fungsi export belum tersedia.');
    }
}


