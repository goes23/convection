<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name',30);
            $table->string('kode',30);
            $table->string('foto')->nullable();
            $table->integer('harga_jual')->nullable();
            $table->integer('harga_modal_product')->nullable();
            // $table->integer('status')->comment('active');
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
        Schema::dropIfExists('product');
    }
}
