<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('produksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produksi');
            $table->integer('product_id');
            $table->integer('bahan_id');
            $table->integer('panjang_bahan');
            $table->integer('bidang');
            $table->integer('total_stock');
            $table->integer('pemakaian');
            $table->integer('harga_potong_satuan');
            $table->integer('harga_jait_satuan');
            $table->integer('harga_finishing_satuan');
            $table->integer('harga_aksesoris');
            $table->integer('harga_modal_bahan_satuan');
            //$table->integer('status')->comment('active');
            $table->integer('created_by');
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
        Schema::dropIfExists('produksi');
    }
}
