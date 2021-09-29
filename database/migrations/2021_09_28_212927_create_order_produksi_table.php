<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProduksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_produksi', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('harga_modal_satuan');
            $table->integer('harga_jual_satuan');
            $table->integer('qty');
            $table->integer('total_pembayaran');
            $table->integer('sisa_pembayaran');
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
        Schema::dropIfExists('order_produksi');
    }
}
