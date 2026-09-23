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
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('is_promo_banner', 'is_banner_hero');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_promo_utama')->default(false)->after('is_banner_hero');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_promo_utama');
            $table->renameColumn('is_banner_hero', 'is_promo_banner');
        });
    }
};
