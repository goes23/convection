<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogOrderProduksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_order_produksi', function (Blueprint $table) {
            $table->id();
            $table->integer('order_produksi_id');
            $table->integer('jumlah_pembayaran');
            $table->dateTime('tanggal_pembayaran');
            $table->string('keterangan');
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
        Schema::dropIfExists('log_order_produksi');
    }
}
