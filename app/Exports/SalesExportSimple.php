<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExportSimple implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Sale::with(['customer', 'saleDetails.product'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Invoice',
            'Pelanggan',
            'Produk',
            'Tanggal',
            'Total',
            'Profit'
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
            $sale->id,
            $sale->customer ? $sale->customer->name : 'Pelanggan Umum',
            $productList,
            $sale->transaction_date->format('d/m/Y'),
            $sale->total_amount,
            $sale->profit_amount
        ];
    }
}
