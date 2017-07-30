<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObatRusakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obat_rusak', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('id_jenis_obat')->unsigned();
            $table->foreign('id_jenis_obat')
                  ->references('id')->on('jenis_obat')
                  ->onDelete('restrict');                        

            $table->integer('id_stok_obat')->unsigned();
            $table->foreign('id_stok_obat')
                  ->references('id')->on('stok_obat')
                  ->onDelete('restrict');     
                  
            $table->dateTime('waktu_keluar');   // Atau pakai timestamp?    
            $table->integer('jumlah');  
            $table->string('alasan');   
            $table->string('keterangan')->nullable();   
            
            $table->integer('asal')->unsigned();                     
            $table->foreign('asal')
                  ->references('id')->on('lokasi_obat')
                  ->onDelete('restrict');
                  
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
        Schema::dropIfExists('obat_rusak');
    }
}
