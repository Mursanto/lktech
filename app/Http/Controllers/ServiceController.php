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
            'items'                              => 'required|array|min:1|max:10',
            'items.*.device_name'                => 'required|string|max:255',
            'items.*.serial_number'              => 'nullable|string|max:255',
            'items.*.equipment_details'          => 'nullable|string|max:500',
            'items.*.complaint'                  => 'required|string',
            'items.*.service_charge'             => 'required|numeric|min:0',
            'items.*.spareparts'                 => 'nullable|array',
            'items.*.spareparts.*.product_id'    => 'nullable|exists:products,id',
            'items.*.spareparts.*.name'          => 'required_with:items.*.spareparts|string|max:255',
            'items.*.spareparts.*.price'         => 'required_with:items.*.spareparts|numeric|min:0',
            'technician_id'        => 'required|exists:users,id',
            'status'               => 'required|string',
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

                $items = $request->items ?? [];
                $firstItem = $items[0] ?? [
                    'device_name' => '-', 'serial_number' => null, 
                    'equipment_details' => null, 'complaint' => '-'
                ];

                $serviceFee     = collect($items)->sum('service_charge');
                $estimatedParts = collect($items)->sum(function($item) {
                    return collect($item['spareparts'] ?? [])->sum('price');
                });
                $totalAmount    = $estimatedParts + $serviceFee;

                // 4. Buat record Servis
                $service = Service::create([
                    'customer_id'          => $customerId,
                    'technician_id'        => $request->technician_id,
                    'device_name'          => $firstItem['device_name'],
                    'serial_number'        => $firstItem['serial_number'] ?? null,
                    'equipment_details'    => $firstItem['equipment_details'] ?? null,
                    'complaint'            => $firstItem['complaint'],
                    'devices'              => [], // Deprecated
                    'status'               => $request->status,
                    'service_fee'          => $serviceFee,
                    'estimated_parts_cost' => $estimatedParts,
                    'total_amount'         => $totalAmount,
                    // Legacy columns fallback
                    'service_type'         => 'Perbaikan Umum',
                    'description'          => $firstItem['complaint'],
                    'device_brand'         => explode(' ', $firstItem['device_name'])[0] ?? '-',
                    'device_model'         => $firstItem['device_name'],
                    'issue_description'    => $firstItem['complaint'],
                    'estimated_cost'       => $totalAmount,
                    'actual_cost'          => 0,
                ]);

                foreach ($items as $itemData) {
                    $service->items()->create([
                        'device_name' => $itemData['device_name'],
                        'serial_number' => $itemData['serial_number'] ?? null,
                        'equipment_details' => $itemData['equipment_details'] ?? null,
                        'complaint' => $itemData['complaint'],
                        'service_charge' => $itemData['service_charge'],
                        'spareparts' => array_values($itemData['spareparts'] ?? []),
                    ]);

                    // Deduct stock for inventory parts
                    if (!empty($itemData['spareparts'])) {
                        foreach ($itemData['spareparts'] as $part) {
                            if (!empty($part['product_id'])) {
                                $product = \App\Models\Product::find($part['product_id']);
                                if ($product) {
                                    $product->decrement('stock');
                                    if ($product->stock <= 0) {
                                        $product->update(['status' => 'sold']);
                                    }
                                }
                            }
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
            'customer_phone' => 'nullable|string|max:50',
            'customer_address' => 'nullable|string|max:500',
            'items'                              => 'required|array|min:1|max:10',
            'items.*.device_name'                => 'required|string|max:255',
            'items.*.serial_number'              => 'nullable|string|max:255',
            'items.*.equipment_details'          => 'nullable|string|max:500',
            'items.*.complaint'                  => 'required|string',
            'items.*.service_charge'             => 'required|numeric|min:0',
            'items.*.spareparts'                 => 'nullable|array',
            'items.*.spareparts.*.product_id'    => 'nullable|exists:products,id',
            'items.*.spareparts.*.name'          => 'required_with:items.*.spareparts|string|max:255',
            'items.*.spareparts.*.price'         => 'required_with:items.*.spareparts|numeric|min:0',
            'technician_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,process,done,cancelled',
            'completion_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $service->status;

        // Update customer details directly from the form
        $customer = \App\Models\Customer::find($request->customer_id);
        if ($customer) {
            $updates = [];
            if ($request->has('customer_email') && $customer->email !== $request->customer_email) {
                $updates['email'] = $request->customer_email;
            }
            if ($request->has('customer_phone') && $customer->phone !== $request->customer_phone) {
                $updates['phone'] = $request->customer_phone;
            }
            if ($request->has('customer_address') && $customer->address !== $request->customer_address) {
                $updates['address'] = $request->customer_address;
            }
            if (!empty($updates)) {
                $customer->update($updates);
            }
        }

        $items = $request->items ?? [];
        $firstItem = $items[0] ?? [
            'device_name' => '-', 'serial_number' => null, 
            'equipment_details' => null, 'complaint' => '-'
        ];

        $serviceFee = collect($items)->sum('service_charge');
        $estimatedPartsCost = collect($items)->sum(function($item) {
            return collect($item['spareparts'] ?? [])->sum('price');
        });

        // Update data beserta fallback kolom lama agar tidak error
        $service->update([
            'customer_id' => $request->customer_id,
            'technician_id' => $request->technician_id,
            'device_name' => $firstItem['device_name'],
            'serial_number' => $firstItem['serial_number'] ?? null,
            'equipment_details' => $firstItem['equipment_details'] ?? null,
            'complaint' => $firstItem['complaint'],
            'devices' => [], // Deprecated
            'status' => $request->status,
            'service_fee' => $serviceFee,
            'estimated_parts_cost' => $estimatedPartsCost,
            'estimated_cost' => $serviceFee + $estimatedPartsCost, // Fallback legacy
            'actual_cost' => $request->actual_cost ?? 0,
            'completion_date' => $request->completion_date,
            'notes' => $request->notes,
            'description' => $firstItem['complaint'], // Fallback legacy
            'issue_description' => $firstItem['complaint'], // Fallback legacy
        ]);

        // Revert old stock before deleting old items
        foreach ($service->items as $oldItem) {
            if (!empty($oldItem->spareparts)) {
                foreach ($oldItem->spareparts as $part) {
                    if (!empty($part['product_id'])) {
                        $product = \App\Models\Product::find($part['product_id']);
                        if ($product) {
                            $product->increment('stock');
                            if ($product->stock > 0 && $product->status === 'sold') {
                                $product->update(['status' => 'available']);
                            }
                        }
                    }
                }
            }
        }

        $service->items()->delete();
        foreach ($items as $itemData) {
            $service->items()->create([
                'device_name' => $itemData['device_name'],
                'serial_number' => $itemData['serial_number'] ?? null,
                'equipment_details' => $itemData['equipment_details'] ?? null,
                'complaint' => $itemData['complaint'],
                'service_charge' => $itemData['service_charge'],
                'spareparts' => array_values($itemData['spareparts'] ?? []),
            ]);

            // Deduct stock for inventory parts
            if (!empty($itemData['spareparts'])) {
                foreach ($itemData['spareparts'] as $part) {
                    if (!empty($part['product_id'])) {
                        $product = \App\Models\Product::find($part['product_id']);
                        if ($product) {
                            $product->decrement('stock');
                            if ($product->stock <= 0) {
                                $product->update(['status' => 'sold']);
                            }
                        }
                    }
                }
            }
        }

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
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ServicesExport, 'servis.xlsx');
    }
}


