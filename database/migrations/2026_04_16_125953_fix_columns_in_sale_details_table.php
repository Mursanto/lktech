<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixColumnsInSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_details', function (Blueprint $table) {
            // Tambahkan kolom yang hilang
            if (!Schema::hasColumn('sale_details', 'quantity')) {
                $table->integer('quantity')->after('product_id');
            }
            if (!Schema::hasColumn('sale_details', 'purchase_price')) {
                $table->decimal('purchase_price', 15, 2)->nullable()->after('price_at_transaction');
            }
            if (!Schema::hasColumn('sale_details', 'profit')) {
                $table->decimal('profit', 15, 2)->nullable()->after('purchase_price');
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
        Schema::table('sale_details', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'purchase_price', 'profit']);
        });
    }
}
