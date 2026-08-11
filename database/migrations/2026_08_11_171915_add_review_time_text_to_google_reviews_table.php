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
        Schema::table('google_reviews', function (Blueprint $table) {
            $table->string('review_time_text')->nullable()->after('review_created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('google_reviews', function (Blueprint $table) {
            $table->dropColumn('review_time_text');
        });
    }
};
