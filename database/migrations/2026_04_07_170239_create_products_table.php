<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->string('brand');
            $table->string('model_series');
            $table->string('serial_number')->unique();
            $table->string('processor');
            $table->string('ram');
            $table->string('storage');
            $table->decimal('screen_size', 8, 2);
            $table->integer('battery_health');
            $table->decimal('battery_runtime', 8, 2);
            $table->text('condition');
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->enum('status', ['available', 'sold', 'booked']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
