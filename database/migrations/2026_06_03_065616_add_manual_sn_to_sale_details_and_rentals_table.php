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
        Schema::table('sale_details', function (Blueprint $table) {
            $table->string('manual_sn')->nullable()->after('product_id');
        });

        Schema::table('rentals', function (Blueprint $table) {
            $table->string('manual_sn')->nullable()->after('serial_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_details', function (Blueprint $table) {
            $table->dropColumn('manual_sn');
        });

        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn('manual_sn');
        });
    }
};
