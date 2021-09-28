<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('bahan', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30);
            $table->string('name', 30);
            $table->integer('harga');
            $table->dateTime('buy_at');
            $table->string('satuan');
            $table->integer('panjang');
            $table->integer('sisa_bahan');
            $table->integer('harga_satuan');
            $table->integer('discount')->nullable();
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
        Schema::dropIfExists('bahan');
    }
}
