<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rentals', function (Blueprint $table) {
            if (!Schema::hasColumn('rentals', 'daily_price')) {
                $table->decimal('daily_price', 15, 2)->default(0)->after('return_date');
            }
            if (!Schema::hasColumn('rentals', 'customer_id')) {
                $table->unsignedBigInteger('customer_id')->nullable()->after('id');
            }
        });
    }

    public function down()
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn(['daily_price', 'customer_id']);
        });
    }
};
