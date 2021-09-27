<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_code');
            $table->integer('penjualan_id');
            $table->integer('product_id');
            $table->integer('sell_price');
            $table->integer('qty');
            $table->string('size');
            $table->integer('total');
            $table->text('keterangan')->nullable( );
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_penjualan');
    }
}
