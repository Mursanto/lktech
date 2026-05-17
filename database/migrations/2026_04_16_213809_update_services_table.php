<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            // Tambahkan relasi dan kolom baru
            if (!Schema::hasColumn('services', 'customer_id')) {
                $table->foreignId('customer_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('services', 'technician_id')) {
                $table->foreignId('technician_id')->nullable()->comment('User ID Teknisi')->after('customer_id');
            }
            if (!Schema::hasColumn('services', 'device_name')) {
                $table->string('device_name')->after('technician_id');
            }
            if (!Schema::hasColumn('services', 'serial_number')) {
                $table->string('serial_number')->nullable()->after('device_name');
            }
            if (!Schema::hasColumn('services', 'complaint')) {
                $table->text('complaint')->nullable()->after('serial_number');
            }
            if (!Schema::hasColumn('services', 'service_fee')) {
                $table->decimal('service_fee', 15, 2)->default(0)->after('status');
            }
            if (!Schema::hasColumn('services', 'total_amount')) {
                $table->decimal('total_amount', 15, 2)->default(0)->after('service_fee');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
