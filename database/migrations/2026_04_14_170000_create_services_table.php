<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->string('service_type');
            $table->text('description');
            $table->string('device_brand');
            $table->string('device_model');
            $table->string('device_serial')->nullable();
            $table->text('issue_description');
            $table->decimal('estimated_cost', 10, 2);
            $table->decimal('actual_cost', 10, 2)->nullable();
            $table->enum('status', ['pending', 'process', 'done', 'cancelled'])->default('pending');
            $table->date('completion_date')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('technician_id')->nullable()->constrained('users');
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
        Schema::dropIfExists('services');
    }
}
