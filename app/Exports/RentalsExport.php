<?php

namespace App\Exports;

use App\Models\Rental;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RentalsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Rental::with(['customer', 'product'])->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No. Kontrak',
            'Penyewa',
            'No. HP',
            'Unit Laptop',
            'Serial Number',
            'Tanggal Sewa',
            'Batas Waktu',
            'Status',
            'Harga Harian',
            'Total Harga'
        ];
    }

    public function map($rental): array
    {
        return [
            '#' . ($rental->rental_number ?? 'RW-' . str_pad($rental->id, 4, '0', STR_PAD_LEFT)),
            $rental->customer->name ?? 'Unknown',
            $rental->customer->phone ?? '-',
            $rental->product ? $rental->product->brand . ' ' . $rental->product->model_series : ($rental->laptop_name ?? 'Unit Tidak Diketahui'),
            $rental->product ? $rental->product->serial_number : 'N/A',
            $rental->rental_date->format('d/m/Y'),
            $rental->return_date->format('d/m/Y'),
            strtoupper($rental->status),
            'Rp ' . number_format($rental->daily_price, 0, ',', '.'),
            'Rp ' . number_format($rental->total_price, 0, ',', '.')
        ];
    }
}
