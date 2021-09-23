<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produksi');
            $table->integer('produksi_id');
            $table->integer('product_id');
            $table->string('size');
            $table->integer('jumlah_produksi');
            $table->integer('sisa_jumlah_produksi')->nullabel();
            $table->integer('jumlah_stock_product')->nullabel();
            $table->integer('harga_jual')->nullabel();
            $table->integer('harga_jual_akhir')->nullabel();
            $table->text('keterangan')->nullabel();
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
        Schema::dropIfExists('variants');
    }
}
