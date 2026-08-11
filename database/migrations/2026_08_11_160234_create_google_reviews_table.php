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
        Schema::create('google_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('google_review_id')->unique()->nullable(); // ID unik dari Google
            $table->string('reviewer_name');
            $table->string('reviewer_photo_url')->nullable();
            $table->integer('star_rating')->default(5);
            $table->text('review_comment');
            $table->timestamp('review_created_at');
            $table->text('review_reply')->nullable(); // Balasan dari pemilik toko
            $table->boolean('is_featured')->default(true); // Control tampil di Landing Page
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_reviews');
    }
};
