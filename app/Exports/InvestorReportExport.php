<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvestorReportExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $data;
    protected $title;
    protected $headers;

    public function __construct(array $data, string $title, array $headers)
    {
        $this->data = $data;
        $this->title = $title;
        $this->headers = $headers;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            [$this->title],
            $this->headers
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Merge cells for title
        $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($this->headers));
        $sheet->mergeCells("A1:{$lastColumn}1");
        
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['bold' => true]],
        ];
    }
}
