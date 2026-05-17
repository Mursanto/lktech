<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProfitLossExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnFormatting, ShouldAutoSize
{
    public function collection()
    {
        return Sale::with(['saleDetails'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Total Penjualan',
            'Total Modal (HPP)',
            'Laba Kotor',
            'Biaya Operasional',
            'Laba Bersih'
        ];
    }

    public function map($sale): array
    {
        // Kalkulasi Langsung dengan sum dari saleDetails
        $totalHpp = $sale->saleDetails->sum('purchase_price');
        $totalProfit = $sale->saleDetails->sum('profit');
        
        // Output Mapping
        return [
            $sale->created_at->format('d/m/Y H:i'),
            $sale->total_amount,                                    // Total Penjualan (B)
            $totalHpp,                                             // Total Modal/HPP (C)
            $totalProfit,                                           // Laba Kotor (D)
            $sale->operational_cost ?? 0,                            // Biaya Operasional (E)
            $totalProfit - ($sale->operational_cost ?? 0)             // Laba Bersih (F)
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Bold branding row (row 1)
            'A1:F1' => [
                'font' => ['bold' => true, 'size' => 14],
                'alignment' => ['horizontal' => 'center']
            ],
            // Bold header row (row 2)
            2 => ['font' => ['bold' => true]],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Total Penjualan
            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Total Modal (HPP)
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Laba Kotor
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Biaya Operasional
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Laba Bersih
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestDataRow();
                $highestColumn = $sheet->getHighestDataColumn();
                
                // Insert branding row at the top
                $sheet->insertNewRowBefore(1, 1);
                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', 'LAPORAN LABA RUGI LKTECH');
                
                // Add totals row at the bottom
                $totalRow = $highestRow + 2;
                $sheet->setCellValue('A' . $totalRow, 'TOTAL');
                $sheet->setCellValue('B' . $totalRow, '=SUM(B3:B' . ($highestRow + 1) . ')');
                $sheet->setCellValue('C' . $totalRow, '=SUM(C3:C' . ($highestRow + 1) . ')');
                $sheet->setCellValue('D' . $totalRow, '=SUM(D3:D' . ($highestRow + 1) . ')');
                $sheet->setCellValue('E' . $totalRow, '=SUM(E3:E' . ($highestRow + 1) . ')');
                $sheet->setCellValue('F' . $totalRow, '=SUM(F3:F' . ($highestRow + 1) . ')');
                
                // Make totals row bold
                $sheet->getStyle('A' . $totalRow . ':F' . $totalRow)->getFont()->setBold(true);
                
                // Apply currency format to totals
                $sheet->getStyle('B' . $totalRow . ':F' . $totalRow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                
                // Add borders to totals row
                $sheet->getStyle('A' . $totalRow . ':F' . $totalRow)->getBorders()->getAllBorders()->setBorderStyle('thin');
            },
        ];
    }
}
