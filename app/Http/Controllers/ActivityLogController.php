<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use App\Exports\ActivityLogsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = $this->getLocalizedActivityLogs($request);

        return view('activity-logs.index', compact('logs'));
    }


    public function show(ActivityLog $activityLog)
    {
        $activityLog->load('user');
        return view('activity-logs.show', compact('activityLog'));
    }

    
    /**
     * Clear all activity logs (Admin only)
     */
    public function clearLogs()
    {
        // Check if user is admin
        if (!Auth::user() || Auth::user()->role !== 'Admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus log aktivitas.');
        }

        // Count logs before deletion for logging
        $logCount = ActivityLog::count();

        // Delete all logs
        ActivityLog::truncate();

        // Log the clear action (this won't be captured since we deleted all logs, but we'll create a new entry)
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'clear_logs',
            'model_type' => 'App\\Models\\ActivityLog',
            'description' => Auth::user()->name . ' membersihkan ' . $logCount . ' log aktivitas',
            'ip_address' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('activity-logs.index')
            ->with('success', 'Semua log aktivitas berhasil dihapus (' . $logCount . ' log).');
    }

    /**
     * Log activity for self-auditing
     */
    private function logActivity($action, $modelType, $description)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $modelType,
            'description' => Auth::user()->name . ' ' . $description,
            'ip_address' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
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
        ];

        return $modelMap[$modelType] ?? $modelType;
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

        // Generate specific descriptions based on action and model
        if ($log->action === 'updated' && $log->model_type === 'App\\Models\\Product') {
            $newValues = $log->new_values ?? [];
            if (isset($newValues['status'])) {
                $productName = ($newValues['brand'] ?? 'Produk') . ' ' . ($newValues['model_series'] ?? '');
                $status = ($newValues['status'] ?? '') === 'sold' ? 'Terjual' : 'Tersedia';
                return "{$user} mengubah status {$productName} menjadi {$status}";
            }
        }

        if ($log->action === 'sale_created') {
            $newValues = $log->new_values ?? [];
            if (isset($newValues['id'])) {
                return "{$user} membuat transaksi penjualan #" . str_pad($newValues['id'], 6, '0', STR_PAD_LEFT);
            }
        }

        if ($log->action === 'sale_deleted') {
            $oldValues = $log->old_values ?? [];
            if (isset($oldValues['id'])) {
                return "{$user} menghapus transaksi penjualan #" . str_pad($oldValues['id'], 6, '0', STR_PAD_LEFT);
            }
        }

        return "{$user} {$action} {$model}";
    }

    /**
     * Backup database (Admin only)
     */
    public function backupDatabase()
    {
        // Log the backup action
        $this->logActivity('backup_database', 'App\\Models\\ActivityLog', 'Backup database lengkap ke file SQL');

        // Get database connection
        $db = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        // Create backup filename
        $filename = 'backup_' . $db . '_' . date('Y-m-d_H-i-s') . '.sql';

        // Build mysqldump command
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($host),
            escapeshellarg($db),
            storage_path('app/backups/' . $filename)
        );

        // Create backups directory if it doesn't exist
        $backupPath = storage_path('app/backups');
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        // Execute backup command
        exec($command, $output, $returnCode);

        if ($returnCode === 0) {
            // Download the backup file
            return response()->download($backupPath . '/' . $filename)->deleteFileAfterSend(true);
        } else {
            return redirect()->back()->with('error', 'Gagal membuat backup database. Silakan hubungi administrator.');
        }
    }

    /**
     * Export activity logs to Excel
     */
    public function export()
    {
        return Excel::download(new ActivityLogsExport, 'log_aktivitas.xlsx');
    }

    /**
     * Get localized data for view
     */
    public function getLocalizedActivityLogs(Request $request = null)
    {
        $query = ActivityLog::with('user');

        if ($request) {
            $query->when($request->search, function($q) use ($request) {
                $search = $request->search;
                $q->where(function($q) use ($search) {
                    $q->where('action', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%")
                      ->orWhereHas('user', function($q) use ($search) {
                          $q->where('name', 'LIKE', "%{$search}%");
                      });
                });
            });

            $query->when($request->module, function($q) use ($request) {
                if ($request->module !== 'all' && $request->module != '') {
                    $q->where('model_type', 'LIKE', "%{$request->module}%");
                }
            });
        }

        $activityLogs = $query->orderBy('created_at', 'desc')->paginate(20);

        if ($request) {
            $activityLogs->appends($request->all());
        }

        // Add localized properties to each log
        $activityLogs->getCollection()->transform(function ($log) {
            $log->localized_model = $this->localizeModelName($log->model_type);
            $log->localized_action = $this->localizeAction($log->action);
            $log->description = $this->generateActivityDescription($log);
            return $log;
        });

        return $activityLogs;
    }
}
