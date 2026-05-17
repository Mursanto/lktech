<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ProfitAuditController;

class ProfitAuditCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profit:audit {--validate : Validate dashboard calculations only}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Audit and recalculate all profit calculations in the system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Profit Audit System ===');
        
        $profitAuditController = new ProfitAuditController();
        
        if ($this->option('validate')) {
            $this->info('Validating dashboard calculations...');
            $response = $profitAuditController->validateDashboardCalculations();
            $data = json_decode($response->getContent(), true);
            
            if ($data['success']) {
                $this->info('Sales Method:');
                $this->info('  Total Omzet: Rp ' . number_format($data['data']['sales_method']['total_omzet'], 0, ',', '.'));
                $this->info('  Total Laba: Rp ' . number_format($data['data']['sales_method']['total_laba'], 0, ',', '.'));
                
                $this->info('Products Method:');
                $this->info('  Total Omzet: Rp ' . number_format($data['data']['products_method']['total_omzet'], 0, ',', '.'));
                $this->info('  Total Laba: Rp ' . number_format($data['data']['products_method']['total_laba'], 0, ',', '.'));
                
                $this->info('Differences:');
                $this->info('  Omzet Difference: Rp ' . number_format($data['data']['differences']['omzet_difference'], 0, ',', '.'));
                $this->info('  Laba Difference: Rp ' . number_format($data['data']['differences']['laba_difference'], 0, ',', '.'));
                
                $this->info('Dashboard validation completed successfully!');
            } else {
                $this->error('Validation failed: ' . $data['message']);
                return 1;
            }
        } else {
            $this->info('Starting comprehensive profit audit and recalculation...');
            $response = $profitAuditController->auditAndRecalculateAll();
            $data = json_decode($response->getContent(), true);
            
            if ($data['success']) {
                $this->info('Audit completed successfully!');
                $this->info('Total sales processed: ' . $data['data']['total_sales_processed']);
                $this->info('Total profit correction: Rp ' . number_format($data['data']['total_profit_correction'], 0, ',', '.'));
                
                $this->table(
                    ['Sale ID', 'Original Profit', 'New Profit', 'Correction'],
                    array_map(function($result) {
                        return [
                            '#' . str_pad($result['sale_id'], 6, '0', STR_PAD_LEFT),
                            'Rp ' . number_format($result['original_profit'], 0, ',', '.'),
                            'Rp ' . number_format($result['new_profit'], 0, ',', '.'),
                            'Rp ' . number_format($result['correction'], 0, ',', '.'),
                        ];
                    }, $data['data']['audit_results'])
                );
                
                $this->info('All profit calculations have been audited and corrected!');
            } else {
                $this->error('Audit failed: ' . $data['message']);
                return 1;
            }
        }
        
        return 0;
    }
}
