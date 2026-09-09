<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('ownership_type', ['lktech', 'investor'])->default('lktech')->after('tipe_stok');
            $table->foreignId('investor_id')->nullable()->after('ownership_type')->constrained('investors')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['investor_id']);
            $table->dropColumn(['ownership_type', 'investor_id']);
        });
    }
};
