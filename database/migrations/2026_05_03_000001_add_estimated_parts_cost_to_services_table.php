<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstimatedPartsCostToServicesTable extends Migration
{
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'estimated_parts_cost')) {
                $table->decimal('estimated_parts_cost', 15, 2)->default(0)->after('service_fee');
            }
        });
    }

    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'estimated_parts_cost')) {
                $table->dropColumn('estimated_parts_cost');
            }
        });
    }
}
