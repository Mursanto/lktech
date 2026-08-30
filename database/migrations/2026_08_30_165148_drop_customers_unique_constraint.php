<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Hapus unique constraint (name, email, phone) pada tabel customers.
     * Constraint ini terlalu ketat: pelanggan yang sama beli lagi
     * akan menyebabkan Integrity constraint violation.
     */
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropUnique('customers_unique_fields');
        });
    }

    /**
     * Kembalikan unique constraint jika di-rollback.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->unique(['name', 'email', 'phone'], 'customers_unique_fields');
        });
    }
};
