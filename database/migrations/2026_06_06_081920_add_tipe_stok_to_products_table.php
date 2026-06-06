<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom tipe_stok ke tabel products.
     * Nilai yang diizinkan: 'ready_stock' dan 'open_order'.
     * Default: 'ready_stock'
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('tipe_stok', 20)->default('ready_stock')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus kolom tipe_stok dari tabel products.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('tipe_stok');
        });
    }
};
