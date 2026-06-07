<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permission = \Spatie\Permission\Models\Permission::create(['name' => 'access_rakit_pc']);

        // assign to Admin role
        $role = \Spatie\Permission\Models\Role::where('name', 'Admin')->first();
        if ($role) {
            $role->givePermissionTo($permission);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $permission = \Spatie\Permission\Models\Permission::where('name', 'access_rakit_pc')->first();
        if ($permission) {
            $permission->delete();
        }
    }
};
