<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManufactureCostUnitPurchaseToManufacturingProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manufacturing_products', function (Blueprint $table) {
            $table->decimal('manufacture_cost_unit_purchase', 15, 4)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manufacturing_products', function (Blueprint $table) {
            $table->dropColumn('manufacture_cost_unit_purchase');
        });
    }
}
