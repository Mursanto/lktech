<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create permissions
        $permissions = [
            'dashboard.view',
            'inventory.view',
            'inventory.create',
            'inventory.edit',
            'inventory.delete',
            'sales.view',
            'sales.create',
            'sales.edit',
            'sales.delete',
            'reports.profit',
            'reports.audit',
            'stock.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $staffRole = Role::firstOrCreate(['name' => 'Staff']);

        // Assign permissions to Admin role (full access)
        $adminRole->givePermissionTo($permissions);

        // Assign permissions to Staff role (limited access)
        $staffRole->givePermissionTo([
            'dashboard.view',
            'stock.view',
            'sales.view',
            'sales.create',
        ]);
    }
}
