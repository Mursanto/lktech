<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with(['customer', 'technician']);

        $query->when($request->search, function ($q) use ($request) {
            $search = trim($request->search);
            $idSearch = $search;
            
            // Bersihkan format nomor servis seperti #SRV-000019 atau #000019 menjadi 19
            if (preg_match('/^#?(?:SRV-)?0*(\d+)$/i', $search, $matches)) {
                $idSearch = $matches[1];
            }

            $q->where(function($q) use ($search, $idSearch) {
                $q->where('device_name', 'LIKE', "%{$search}%")
                  ->orWhere('id', 'LIKE', "%{$idSearch}%")
                  ->orWhere('serial_number', 'LIKE', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  });
            });
        });

        $query->when($request->status, function ($q) use ($request) {
            if ($request->status !== 'all') {
                $q->where('status', $request->status);
            }
        });

        $services = $query->orderBy('created_at', 'desc')->paginate(20)->appends($request->all());
            
        return view('services.index', compact('services'));
    }

    public function create()
    {
        $customers = \App\Models\Customer::all();
        
        // Filter hanya user dengan role 'Teknisi' atau 'Staff' untuk menghindari duplikasi
        $technicians = \App\Models\User::whereHas('roles', function($query) {
            $query->whereIn('name', ['Teknisi', 'Staff']);
        })->distinct()->orderBy('name')->get();
        
        $categories = \App\Models\Category::all();
        
        // Ambil produk untuk sparepart
        $groupedProducts = \App\Models\Product::with('category')
            ->whereHas('category', function($q) {
                $q->whereIn('type_category', ['peripheral', 'service']);
            })
            ->where(function ($q) {
                $q->where('stock', '>', 0)
                  ->orWhereHas('category', function($cat) {
                      $cat->where('type_category', 'service');
                  });
            })
            ->get()
            ->groupBy(function($data) {
                return $data->category->name ?? 'Lainnya';
            });

        return view('services.create', compact('customers', 'technicians', 'categories', 'groupedProducts'));
    }

    public function show(Service $service)
    {
        // Load relasi agar tidak N+1 query
        $service->load(['customer', 'technician']);
        return view('services.show', compact('service'));
    }

    public function store(Request $request)
    {
        // 1. Tentukan apakah ini pelanggan baru
        $isNewCustomer = $request->has('is_new_customer') && $request->is_new_customer == '1';

        // 2. Validasi Dinamis
        $rules = [
            'device_name'          => 'required|string|max:255',
            'serial_number'        => 'nullable|string|max:255',
            'equipment_details'    => 'nullable|string|max:500',
            'complaint'            => 'required|string',
            'technician_id'        => 'required|exists:users,id',
            'status'               => 'required|string',
            'service_fee'          => 'required|numeric|min:0',
            'estimated_parts_cost' => 'nullable|numeric|min:0',
            'parts'                => 'nullable|array',
            'parts.*'              => 'exists:products,id',
        ];

        if ($isNewCustomer) {
            $rules['new_customer_name']    = 'required|string|max:255';
            $rules['new_customer_phone']   = 'required|string|max:20';
            $rules['new_customer_email']   = 'nullable|email|max:255';
            $rules['new_customer_address'] = 'nullable|string';
        } else {
            $rules['customer_id'] = 'required|exists:customers,id';
        }

        $request->validate($rules);

        try {
            $service = DB::transaction(function () use ($request, $isNewCustomer) {

                // 3. Tangani Pelanggan
                if ($isNewCustomer) {
                    $customer = Customer::create([
                        'name'    => $request->new_customer_name,
                        'phone'   => $request->new_customer_phone,
                        'email'   => $request->new_customer_email,
                        'address' => $request->new_customer_address,
                    ]);
                    $customerId = $customer->id;
                } else {
                    $customerId = $request->customer_id;
                }

                $estimatedParts = $request->estimated_parts_cost ?? 0;
                $serviceFee     = $request->service_fee ?? 0;
                $totalAmount    = $estimatedParts + $serviceFee;

                // 4. Buat record Servis
                $service = Service::create([
                    'customer_id'          => $customerId,
                    'technician_id'        => $request->technician_id,
                    'device_name'          => $request->device_name,
                    'serial_number'        => $request->serial_number,
                    'equipment_details'    => $request->equipment_details,
                    'complaint'            => $request->complaint,
                    'status'               => $request->status,
                    'service_fee'          => $serviceFee,
                    'estimated_parts_cost' => $estimatedParts,
                    'total_amount'         => $totalAmount,
                    // Legacy columns fallback
                    'service_type'         => 'Perbaikan Umum',
                    'description'          => $request->complaint,
                    'device_brand'         => explode(' ', $request->device_name)[0] ?? '-',
                    'device_model'         => $request->device_name,
                    'issue_description'    => $request->complaint,
                    'estimated_cost'       => $totalAmount,
                    'actual_cost'          => 0,
                ]);

                // 5. Kurangi stok sparepart yang dipakai (opsional)
                if ($request->has('parts') && is_array($request->parts)) {
                    foreach ($request->parts as $productId) {
                        $part = \App\Models\Product::find($productId);
                        if ($part && $part->stock > 0) {
                            $part->decrement('stock');
                            if ($part->stock == 0) $part->update(['status' => 'sold']);
                        }
                        // Attach to service parts pivot if relation exists
                        if (method_exists($service, 'parts')) {
                            $service->parts()->syncWithoutDetaching([$productId => ['product_id' => $productId]]);
                        }
                    }
                }

                return $service;
            });

            return redirect()->route('services.index')
                ->with('success', 'Servis baru berhasil ditambahkan!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(Service $service)
    {
        $customers = \App\Models\Customer::all();
        
        // Filter hanya user dengan role 'Teknisi' atau 'Staff' untuk menghindari duplikasi
        $technicians = \App\Models\User::whereHas('roles', function($query) {
            $query->whereIn('name', ['Teknisi', 'Staff']);
        })->distinct()->orderBy('name')->get();
        
        $categories = \App\Models\Category::all();
        
        // Ambil produk untuk sparepart
        $groupedProducts = \App\Models\Product::with('category')
            ->whereHas('category', function($q) {
                $q->whereIn('type_category', ['peripheral', 'service']);
            })
            ->where(function ($q) {
                $q->where('stock', '>', 0)
                  ->orWhereHas('category', function($cat) {
                      $cat->where('type_category', 'service');
                  });
            })
            ->get()
            ->groupBy(function($data) {
                return $data->category->name ?? 'Lainnya';
            });

        return view('services.edit', compact('service', 'customers', 'technicians', 'categories', 'groupedProducts'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'customer_email' => 'nullable|email|max:255',
            'device_name' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'equipment_details' => 'nullable|string|max:500',
            'complaint' => 'required|string',
            'technician_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,process,done,cancelled',
            'service_fee' => 'required|numeric|min:0',
            'actual_cost' => 'nullable|numeric|min:0',
            'completion_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $service->status;

        // Update customer email if provided
        if ($request->filled('customer_email')) {
            $customer = \App\Models\Customer::find($request->customer_id);
            if ($customer && $customer->email !== $request->customer_email) {
                $customer->update(['email' => $request->customer_email]);
            }
        }

        // Handle Spareparts Sync
        $oldPartIds = $service->parts()->pluck('product_id')->toArray();
        $newPartIds = $request->parts ?? [];

        $removedParts = array_diff($oldPartIds, $newPartIds);
        $addedParts = array_diff($newPartIds, $oldPartIds);

        // Kembalikan stok untuk part yang dihapus
        foreach ($removedParts as $removedId) {
            $part = \App\Models\Product::find($removedId);
            if ($part) {
                $part->increment('stock');
                if ($part->stock > 0) $part->update(['status' => 'available']);
            }
            $service->parts()->where('product_id', $removedId)->delete();
        }

        // Kurangi stok untuk part yang baru ditambahkan
        foreach ($addedParts as $addedId) {
            $part = \App\Models\Product::find($addedId);
            if ($part) {
                if ($part->stock <= 0) {
                    return back()->withInput()->withErrors(['parts' => "Stok produk {$part->brand} {$part->model_series} tidak mencukupi."]);
                }
                $part->decrement('stock');
                if ($part->stock == 0) $part->update(['status' => 'sold']);
                
                \App\Models\ServicePart::create([
                    'service_id' => $service->id,
                    'product_id' => $part->id,
                    'part_name' => trim($part->brand . ' ' . $part->model_series),
                    'price' => $part->price ?? 0,
                    'quantity' => 1,
                ]);
            }
        }

        // Auto calculate estimated parts cost if parts are selected
        $calculatedPartsCost = $service->parts()->sum('price');
        $estimatedPartsCost = $request->estimated_parts_cost > 0 ? $request->estimated_parts_cost : $calculatedPartsCost;

        // Update data beserta fallback kolom lama agar tidak error
        $service->update([
            'customer_id' => $request->customer_id,
            'technician_id' => $request->technician_id,
            'device_name' => $request->device_name,
            'serial_number' => $request->serial_number,
            'equipment_details' => $request->equipment_details,
            'complaint' => $request->complaint,
            'status' => $request->status,
            'service_fee' => $request->service_fee,
            'estimated_parts_cost' => $estimatedPartsCost,
            'estimated_cost' => $request->service_fee + $estimatedPartsCost, // Fallback legacy
            'actual_cost' => $request->actual_cost ?? 0,
            'completion_date' => $request->completion_date,
            'notes' => $request->notes,
            'description' => $request->complaint, // Fallback legacy
            'issue_description' => $request->complaint, // Fallback legacy
        ]);

        // If status changed to 'done' and has payment, create/update sale record
        if ($service->status === 'done' && $request->actual_cost > 0 && $oldStatus !== 'done') {
            \App\Models\Sale::create([
                'user_id' => Auth::id(),
                'customer_id' => $service->customer_id,
                'total_amount' => $request->actual_cost,
                'profit_amount' => $request->actual_cost - ($service->service_fee ?? 0),
                'operational_cost' => 0,
                'transaction_date' => now(),
            ]);
        }

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'service_updated',
            'model_type' => Service::class,
            'model_id' => $service->id,
            'old_values' => ['status' => $oldStatus],
            'new_values' => ['status' => $service->status],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'service_deleted',
            'model_type' => Service::class,
            'model_id' => $service->id,
            'old_values' => [
                'customer_id' => $service->customer_id,
                'service_type' => $service->service_type,
            ],
            'new_values' => null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('services.index')
            ->with('success', 'Service deleted successfully.');
    }

    public function print(Service $service)
    {
        $service->load(['customer', 'technician']);
        return view('services.print', compact('service'));
    }

    public function export()
    {
        return redirect()->back()->with('error', 'Fungsi export belum tersedia.');
    }
}


