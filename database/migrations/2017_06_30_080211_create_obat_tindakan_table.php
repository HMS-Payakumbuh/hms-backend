<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObatTindakanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obat_tindakan', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_jenis_obat')->unsigned();
            $table->foreign('id_jenis_obat')
                  ->references('id')->on('jenis_obat')
                  ->onDelete('restrict');

            $table->integer('id_stok_obat')->unsigned();
            $table->foreign('id_stok_obat')
                  ->references('id')->on('stok_obat')
                  ->onDelete('restrict');

            $table->dateTime('waktu_keluar');
            $table->integer('jumlah');
            $table->string('keterangan')->nullable();

            $table->integer('asal')->unsigned();
            $table->foreign('asal')
                  ->references('id')->on('lokasi_obat')
                  ->onDelete('restrict');

            $table->integer('id_transaksi')->unsigned();
            $table->foreign('id_transaksi')
                  ->references('id')->on('transaksi')
                  ->onDelete('restrict');

            $table->integer('id_tindakan')->unsigned();
            $table->foreign('id_tindakan')
                  ->references('id')->on('tindakan')
                  ->onDelete('restrict');

            $table->decimal('harga_jual_realisasi', 12, 2)->nullable();

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
        Schema::dropIfExists('obat_tindakan');
    }
}
