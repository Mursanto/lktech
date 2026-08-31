<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ubah kolom transaction_date dari DATE menjadi DATETIME
     * agar jam transaksi tersimpan dengan benar (tidak selalu 00:00).
     */
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dateTime('transaction_date')->change();
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->date('transaction_date')->change();
        });
    }
};
