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
            $table->date('payout_date')->nullable()->after('investor_payout_status');
            $table->string('payout_account')->nullable()->after('payout_date');
            $table->string('payout_attachment')->nullable()->after('payout_account');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_details', function (Blueprint $table) {
            $table->dropColumn(['payout_date', 'payout_account', 'payout_attachment']);
        });
    }
};
