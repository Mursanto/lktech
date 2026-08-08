<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->enum('order_status', ['menunggu_pembayaran', 'diproses', 'selesai', 'batal'])->default('menunggu_pembayaran')->after('payment_status');
        });

        // Backfill existing data
        DB::table('sales')->where('payment_status', 'success')->update(['order_status' => 'selesai']);
        DB::table('sales')->where('payment_status', 'failed')->update(['order_status' => 'batal']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('order_status');
        });
    }
};
