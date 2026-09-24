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
        Schema::table('investors', function (Blueprint $table) {
            $table->timestamp('pks_agreed_at')->nullable()->after('share_percentage');
            $table->string('pks_agreed_ip', 45)->nullable()->after('pks_agreed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investors', function (Blueprint $table) {
            $table->dropColumn(['pks_agreed_at', 'pks_agreed_ip']);
        });
    }
};
