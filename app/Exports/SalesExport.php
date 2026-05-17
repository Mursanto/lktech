<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $search;
    protected $dateFilter;

    public function __construct($search = '', $dateFilter = 'all')
    {
        $this->search = $search;
        $this->dateFilter = $dateFilter;
    }

    public function collection()
    {
        $query = Sale::with(['customer', 'user', 'saleDetails.product']);

        // Apply customer name filter
        if (!empty($this->search)) {
            $query->whereHas('customer', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        // Apply date filter
        switch ($this->dateFilter) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case 'week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year);
                break;
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No Invoice',
            'Nama Pelanggan',
            'Produk',
            'Tanggal',
            'Total Harga',
            'Laba',
            'Nama Sales'
        ];
    }

    public function map($sale): array
    {
        // Get product names
        $products = [];
        foreach ($sale->saleDetails as $detail) {
            $products[] = $detail->product->brand . ' ' . $detail->product->model_series;
        }
        $productList = implode(', ', $products);

        return [
            '#' . str_pad($sale->id, 6, '0', STR_PAD_LEFT),
            $sale->customer ? $sale->customer->name : 'Pelanggan Umum',
            $productList,
            $sale->transaction_date->format('d/m/Y'),
            'Rp ' . number_format($sale->total_amount, 0, ',', '.'),
            'Rp ' . number_format($sale->profit_amount, 0, ',', '.'),
            $sale->user->name
        ];
    }
}
