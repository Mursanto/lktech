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
        Schema::create('web_settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko')->nullable();
            $table->text('deskripsi_footer')->nullable();
            $table->text('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->string('jam_operasional')->nullable();
            $table->text('maps_iframe')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->longText('tentang_kami')->nullable();
            $table->longText('kebijakan_garansi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_settings');
    }
};
