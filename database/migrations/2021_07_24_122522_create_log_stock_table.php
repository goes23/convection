<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_stock', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('produksi_id');
            $table->integer('variant_id');
            $table->string('transaksi')->nullable()->comment("tambah/ kurang");
            $table->text('keterangan')->nullable();
            $table->integer('qty')->nullable();
            $table->dateTime('transfer_date');
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
        Schema::dropIfExists('log_stock');
    }
}
