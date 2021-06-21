<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penjualan');
            $table->unsignedBigInteger('id_produk');
            $table->integer('harga_jual');
            $table->integer('jumlah');
            $table->tinyInteger('diskon');
            $table->integer('subtotal');
            $table->timestamps();
        });

        Schema::table('penjualans_detail', function (Blueprint $table) {
            $table->foreign('id_penjualan')->references('id')->on('penjualans')
            ->onDelete('restrict')
            ->onUpdate('restrict');

            $table->foreign('id_produk')->references('id')->on('produks')
            ->onDelete('restrict')
            ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualans_detail');
    }
}
