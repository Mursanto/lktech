<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class InvestorRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat permission khusus investor
        $permission = Permission::firstOrCreate([
            'name'       => 'view_investor_dashboard',
            'guard_name' => 'web',
        ]);

        // Buat role Investor (jika belum ada)
        $role = Role::firstOrCreate([
            'name'       => 'Investor',
            'guard_name' => 'web',
        ]);

        // Assign permission ke role
        $role->givePermissionTo($permission);

        $this->command->info('✅ Role Investor dan permission view_investor_dashboard berhasil dibuat.');
    }
}
