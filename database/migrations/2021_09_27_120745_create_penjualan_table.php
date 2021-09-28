<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_code');
            $table->string('kode_pesanan');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_address');
            $table->integer('channel_id');
            //$table->integer('total_order')->comment('jumlah semua dari order item');
            $table->dateTime('purchase_date');
            $table->integer('total_purchase');
            $table->string('shipping_price');
            $table->integer('status');
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
        Schema::dropIfExists('penjualan');
    }
}
