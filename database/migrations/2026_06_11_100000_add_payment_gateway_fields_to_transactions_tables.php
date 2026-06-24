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
        // Add payment fields to 'sales' table if they don't exist
        Schema::table('sales', function (Blueprint $table) {
            if (!Schema::hasColumn('sales', 'payment_status')) {
                $table->string('payment_status')->default('pending')->comment('pending, success, expired, failed');
            }
            if (!Schema::hasColumn('sales', 'payment_method')) {
                $table->string('payment_method')->nullable()->comment('qris, gopay, etc');
            }
            if (!Schema::hasColumn('sales', 'payment_reference_id')) {
                $table->string('payment_reference_id')->nullable()->comment('Gateway transaction ID');
            }
        });

        // Add payment fields to 'services' table if they don't exist
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'payment_status')) {
                $table->string('payment_status')->default('pending');
            }
            if (!Schema::hasColumn('services', 'payment_method')) {
                $table->string('payment_method')->nullable();
            }
            if (!Schema::hasColumn('services', 'payment_reference_id')) {
                $table->string('payment_reference_id')->nullable();
            }
        });

        // Add payment fields to 'rentals' table if they don't exist
        Schema::table('rentals', function (Blueprint $table) {
            if (!Schema::hasColumn('rentals', 'payment_status')) {
                $table->string('payment_status')->default('pending');
            }
            if (!Schema::hasColumn('rentals', 'payment_method')) {
                $table->string('payment_method')->nullable();
            }
            if (!Schema::hasColumn('rentals', 'payment_reference_id')) {
                $table->string('payment_reference_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            if (Schema::hasColumn('sales', 'payment_reference_id')) {
                $table->dropColumn('payment_reference_id');
            }
            // Note: We avoid dropping payment_method/payment_status if they were pre-existing 
            // but for simplicity in rollback of THIS migration we only drop the reference_id 
            // since the other two were already there.
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'payment_method', 'payment_reference_id']);
        });

        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'payment_method', 'payment_reference_id']);
        });
    }
};
