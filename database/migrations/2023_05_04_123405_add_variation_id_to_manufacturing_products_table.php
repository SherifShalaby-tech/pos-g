<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVariationIdToManufacturingProductsTable extends Migration
{

    public function up()
    {
        Schema::table('manufacturing_products', function (Blueprint $table) {
            $table->unsignedBigInteger('variation_id')->nullable();
            $table->foreign('variation_id')->references('id')->on('variations');
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
            //
        });
    }
}
