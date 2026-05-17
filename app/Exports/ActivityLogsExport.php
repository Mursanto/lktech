<?php

namespace App\Exports;

use App\Models\ActivityLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ActivityLogsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Pengguna',
            'Aksi',
            'Deskripsi',
            'IP Address'
        ];
    }

    public function map($log): array
    {
        return [
            $log->created_at->format('d/m/Y H:i:s'),
            $log->user->name ?? 'Pengguna Dihapus',
            $this->localizeAction($log->action),
            $this->generateActivityDescription($log),
            $log->ip_address ?? '-'
        ];
    }

    /**
     * Localize action names to Indonesian
     */
    private function localizeAction($action)
    {
        $actionMap = [
            'created' => 'Tambah Data',
            'updated' => 'Perbarui Data',
            'deleted' => 'Hapus Data',
            'sale_created' => 'Tambah Penjualan',
            'sale_deleted' => 'Hapus Penjualan',
            'product_updated' => 'Perbarui Produk',
            'product_created' => 'Tambah Produk',
            'product_deleted' => 'Hapus Produk',
            'export_logs' => 'Export Log',
            'clear_logs' => 'Bersihkan Log',
            'export_sales' => 'Export Penjualan',
        ];

        return $actionMap[$action] ?? ucfirst($action);
    }

    /**
     * Generate human-readable description for activity
     */
    private function generateActivityDescription($log)
    {
        $action = $this->localizeAction($log->action);
        $model = $this->localizeModelName($log->model_type);
        $user = $log->user->name ?? 'Pengguna Dihapus';

        // Return basic description for export
        return "{$action} - {$model}";
    }

    /**
     * Localize model names to Indonesian
     */
    private function localizeModelName($modelType)
    {
        $modelMap = [
            'App\\Models\\Product' => 'Produk',
            'App\\Models\\Sale' => 'Penjualan',
            'App\\Models\\Customer' => 'Pelanggan',
            'App\\Models\\Category' => 'Kategori',
            'App\\Models\\User' => 'Pengguna',
            'App\\Models\\ActivityLog' => 'Log Aktivitas',
        ];

        return $modelMap[$modelType] ?? $modelType;
    }
}
