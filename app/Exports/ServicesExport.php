<?php

namespace App\Exports;

use App\Models\Service;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ServicesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Service::with(['customer', 'technician'])->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No. Nota',
            'Pelanggan',
            'No. HP',
            'Perangkat',
            'Keluhan',
            'Status',
            'Teknisi',
            'Biaya Servis',
            'Biaya Part',
            'Total Biaya',
            'Tanggal Dibuat'
        ];
    }

    public function map($service): array
    {
        return [
            '#' . ($service->service_number ?? str_pad($service->id, 5, '0', STR_PAD_LEFT)),
            $service->customer ? $service->customer->name : 'Umum',
            $service->customer ? $service->customer->phone : '-',
            $service->device_name,
            $service->complaint,
            strtoupper($service->status),
            $service->technician ? $service->technician->name : '-',
            'Rp ' . number_format($service->service_fee, 0, ',', '.'),
            'Rp ' . number_format($service->estimated_parts_cost, 0, ',', '.'),
            'Rp ' . number_format($service->total_amount, 0, ',', '.'),
            $service->created_at->format('d/m/Y')
        ];
    }
}
