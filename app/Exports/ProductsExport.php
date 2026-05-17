<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Product::with('category')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Produk',
            'Kategori',
            'SKU',
            'Harga Beli',
            'Harga Jual',
            'Stok',
            'Status',
            'Tanggal Dibuat'
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->category ? $product->category->name : '-',
            $product->sku ?? '-',
            $product->purchase_price,
            $product->selling_price,
            $product->stock,
            $product->status === 'available' ? 'Tersedia' : 'Tidak Tersedia',
            $product->created_at->format('d/m/Y')
        ];
    }
}
