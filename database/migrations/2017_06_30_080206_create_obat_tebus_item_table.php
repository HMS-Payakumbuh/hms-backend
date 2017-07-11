<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObatTebusItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obat_tebus_item', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_obat_tebus')->unsigned();
            $table->foreign('id_obat_tebus')
                  ->references('id')->on('obat_tebus')
                  ->onDelete('restrict');            
            
            $table->integer('id_jenis_obat')->unsigned();
            $table->foreign('id_jenis_obat')
                  ->references('id')->on('jenis_obat')
                  ->onDelete('restrict');
            
            $table->integer('id_obat_masuk')->unsigned();
            $table->foreign('id_obat_masuk')
                  ->references('id')->on('obat_masuk')
                  ->onDelete('restrict');
                  
            $table->dateTime('waktu_keluar');   // Atau pakai timestamp?    
            $table->integer('jumlah');  
            $table->string('keterangan')->nullable();
            
            $table->integer('asal')->unsigned();                     
            $table->foreign('asal')
                  ->references('id')->on('lokasi_obat')
                  ->onDelete('restrict');

            $table->integer('id_resep_item')->unsigned();  
            $table->foreign('id_resep_item')
                  ->references('id')->on('resep_item')
                  ->onDelete('restrict');

            $table->integer('id_racikan_item')->unsigned();  
            $table->foreign('id_racikan_item')
                  ->references('id')->on('racikan_item')
                  ->onDelete('restrict');

            $table->decimal('harga_jual_realisasi', 12, 2);
                  
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
        Schema::dropIfExists('obat_tebus_item');
    }
}
