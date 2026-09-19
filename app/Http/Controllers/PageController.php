<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JasaWebsite;
use App\Models\WifiVoucher;
use App\Models\Service;
use App\Models\Rental;

class PageController extends Controller
{
    public function jasaWebsite()
    {
        $packages = JasaWebsite::where('is_active', true)->orderBy('harga_mulai', 'asc')->get();
        return view('pages.jasa-website', compact('packages'));
    }

    public function wifiVoucher()
    {
        $packages = WifiVoucher::where('is_active', true)->orderBy('harga', 'asc')->get();
        return view('pages.wifi-voucher', compact('packages'));
    }

    public function servicePc()
    {
        return view('pages.service-pc');
    }

    public function sewaLaptop()
    {
        return view('pages.sewa-laptop');
    }

    /**
     * API: Cek status service berdasarkan nomor tiket / nomor ID
     */
    public function trackService(Request $request)
    {
        $q = trim($request->input('q', ''));

        if (!$q) {
            return response()->json(['found' => false, 'message' => 'Masukkan nomor tiket terlebih dahulu.']);
        }

        // Parse nomor tiket: SVC-YYYY-NNNN (ambil NNNN), atau angka langsung
        $id = null;
        if (preg_match('/(?:SVC|INV)-\d{4}-(\d+)/i', $q, $m)) {
            $id = (int)$m[1];
        } elseif (preg_match('/^(\d+)$/', trim($q), $m)) {
            $id = (int)$m[1];
        } elseif (preg_match('/(\d+)$/', $q, $m)) {
            $id = (int)$m[1];
        }
        $service = null;
        if ($id) {
            $service = Service::with(['customer', 'items', 'technician'])->find($id);
        }

        if (!$service) {
            return response()->json(['found' => false, 'message' => 'Data service tidak ditemukan. Pastikan nomor tiket sudah benar.']);
        }

        $statusMap = [
            'pending'   => ['label' => 'Menunggu / Antrian', 'color' => 'yellow', 'icon' => '⏳'],
            'process'   => ['label' => 'Sedang Diproses', 'color' => 'blue', 'icon' => '🔧'],
            'done'      => ['label' => 'Selesai', 'color' => 'green', 'icon' => '✅'],
            'cancelled' => ['label' => 'Dibatalkan', 'color' => 'red', 'icon' => '❌'],
        ];
        $statusInfo = $statusMap[$service->status] ?? ['label' => $service->status, 'color' => 'gray', 'icon' => '❓'];

        $devices = [];
        if ($service->items && $service->items->count()) {
            foreach ($service->items as $item) {
                $devices[] = [
                    'device'    => $item->device_name,
                    'complaint' => $item->complaint,
                    'charge'    => number_format($item->service_charge ?? 0, 0, ',', '.'),
                ];
            }
        } elseif ($service->device_name) {
            $devices[] = [
                'device'    => $service->device_name,
                'complaint' => $service->complaint,
                'charge'    => number_format($service->service_fee ?? 0, 0, ',', '.'),
            ];
        }

        return response()->json([
            'found'          => true,
            'ticket_no'      => 'SVC-' . date('Y', strtotime($service->created_at)) . '-' . str_pad($service->id, 4, '0', STR_PAD_LEFT),
            'customer_name'  => $service->customer?->name ?? '-',
            'customer_phone' => $service->customer?->phone ?? '-',
            'status'         => $service->status,
            'status_label'   => $statusInfo['label'],
            'status_color'   => $statusInfo['color'],
            'status_icon'    => $statusInfo['icon'],
            'technician'     => $service->technician?->name ?? '-',
            'devices'        => $devices,
            'total'          => number_format($service->total_amount ?? $service->service_fee ?? 0, 0, ',', '.'),
            'payment_status' => $service->payment_status,
            'completion_date'=> $service->completion_date ? \Carbon\Carbon::parse($service->completion_date)->format('d M Y') : '-',
            'created_at'     => $service->created_at->format('d M Y'),
            'notes'          => $service->notes,
        ]);
    }

    /**
     * API: Cek status sewa berdasarkan nomor kontrak / ID
     */
    public function trackRental(Request $request)
    {
        $q = trim($request->input('q', ''));

        if (!$q) {
            return response()->json(['found' => false, 'message' => 'Masukkan nomor kontrak terlebih dahulu.']);
        }

        // Parse nomor kontrak: RNT-YYYY-NNNN (ambil NNNN), atau angka langsung
        $id = null;
        if (preg_match('/(?:RNT|INV)-\d{4}-(\d+)/i', $q, $m)) {
            $id = (int)$m[1];
        } elseif (preg_match('/^(\d+)$/', trim($q), $m)) {
            $id = (int)$m[1];
        } elseif (preg_match('/(\d+)$/', $q, $m)) {
            $id = (int)$m[1];
        }

        $rental = null;
        if ($id) {
            $rental = Rental::with('customer')->find($id);
        }

        if (!$rental) {
            return response()->json(['found' => false, 'message' => 'Data sewa tidak ditemukan. Pastikan nomor kontrak sudah benar.']);
        }

        $statusMap = [
            'active'    => ['label' => 'Aktif (Sedang Disewa)', 'color' => 'blue', 'icon' => '🟢'],
            'completed' => ['label' => 'Selesai (Dikembalikan)', 'color' => 'green', 'icon' => '✅'],
            'overdue'   => ['label' => 'Terlambat', 'color' => 'red', 'icon' => '⚠️'],
            'cancelled' => ['label' => 'Dibatalkan', 'color' => 'red', 'icon' => '❌'],
        ];
        $statusInfo = $statusMap[$rental->status] ?? ['label' => $rental->status, 'color' => 'gray', 'icon' => '❓'];

        $paymentMap = [
            'pending'   => 'Belum Lunas',
            'success'   => 'Lunas',
            'failed'    => 'Gagal',
            'cancelled' => 'Dibatalkan',
        ];

        return response()->json([
            'found'          => true,
            'contract_no'    => 'RNT-' . date('Y', strtotime($rental->created_at)) . '-' . str_pad($rental->id, 4, '0', STR_PAD_LEFT),
            'customer_name'  => $rental->customer_name ?? '-',
            'customer_phone' => $rental->customer?->phone ?? $rental->customer_phone ?? '-',
            'laptop_name'    => $rental->laptop_name ?? '-',
            'serial_number'  => $rental->serial_number ?? '-',
            'rental_date'    => \Carbon\Carbon::parse($rental->rental_date)->format('d M Y'),
            'return_date'    => \Carbon\Carbon::parse($rental->return_date)->format('d M Y'),
            'status'         => $rental->status,
            'status_label'   => $statusInfo['label'],
            'status_color'   => $statusInfo['color'],
            'status_icon'    => $statusInfo['icon'],
            'total'          => number_format($rental->total_price ?? 0, 0, ',', '.'),
            'payment_status' => $paymentMap[$rental->payment_status] ?? $rental->payment_status,
            'payment_method' => $rental->payment_method ?? '-',
            'notes'          => $rental->notes,
            'created_at'     => $rental->created_at->format('d M Y'),
        ]);
    }

    /**
     * API: Daftar semua service berdasarkan status tab
     */
    public function listServices(Request $request)
    {
        $status = $request->input('status', 'pending');
        $q      = trim($request->input('q', ''));

        $query = Service::with(['customer', 'items'])
            ->where('status', $status)
            ->orderBy('created_at', 'desc');

        if ($q) {
            $id = null;
            if (preg_match('/(\d+)/', $q, $m)) $id = (int)$m[1];
            $query->where(function($qu) use ($q, $id) {
                if ($id) $qu->orWhere('id', $id);
                $qu->orWhereHas('customer', fn($c) => $c->where('name', 'like', "%$q%"))
                   ->orWhere('device_name', 'like', "%$q%");
            });
        }

        $services = $query->take(20)->get()->map(function($s) {
            $statusMap = ['pending'=>'Menunggu','process'=>'Diproses','done'=>'Selesai','cancelled'=>'Batal'];
            $devices = $s->items->pluck('device_name')->filter()->implode(', ') ?: $s->device_name;
            return [
                'id'          => $s->id,
                'ticket_no'   => 'SVC-'.date('Y', strtotime($s->created_at)).'-'.str_pad($s->id,4,'0',STR_PAD_LEFT),
                'customer'    => $s->customer?->name ?? '-',
                'device'      => $devices ?? '-',
                'status'      => $s->status,
                'status_label'=> $statusMap[$s->status] ?? $s->status,
                'total'       => number_format($s->total_amount ?? $s->service_fee ?? 0, 0, ',', '.'),
                'date'        => $s->created_at->format('d M Y'),
            ];
        });

        return response()->json(['data' => $services]);
    }

    /**
     * API: Daftar semua rental berdasarkan status tab
     */
    public function listRentals(Request $request)
    {
        $status = $request->input('status', 'active');
        $q      = trim($request->input('q', ''));

        $query = Rental::with('customer')
            ->where('status', $status)
            ->orderBy('created_at', 'desc');

        if ($q) {
            $id = null;
            if (preg_match('/(\d+)/', $q, $m)) $id = (int)$m[1];
            $query->where(function($qu) use ($q, $id) {
                if ($id) $qu->orWhere('id', $id);
                $qu->orWhere('customer_name', 'like', "%$q%")
                   ->orWhere('laptop_name', 'like', "%$q%");
            });
        }

        $rentals = $query->take(20)->get()->map(function($r) {
            $statusMap = ['active'=>'Aktif','completed'=>'Selesai','overdue'=>'Terlambat','cancelled'=>'Batal'];
            return [
                'id'          => $r->id,
                'contract_no' => 'RNT-'.date('Y', strtotime($r->created_at)).'-'.str_pad($r->id,4,'0',STR_PAD_LEFT),
                'customer'    => $r->customer_name ?? '-',
                'laptop'      => $r->laptop_name ?? '-',
                'status'      => $r->status,
                'status_label'=> $statusMap[$r->status] ?? $r->status,
                'rental_date' => \Carbon\Carbon::parse($r->rental_date)->format('d M Y'),
                'return_date' => \Carbon\Carbon::parse($r->return_date)->format('d M Y'),
                'total'       => number_format($r->total_price ?? 0, 0, ',', '.'),
                'date'        => $r->created_at->format('d M Y'),
            ];
        });

        return response()->json(['data' => $rentals]);
    }
}
