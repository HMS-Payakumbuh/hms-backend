<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObatPindahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obat_pindah', function (Blueprint $table) {
            // $table->increments('id');
			
            $table->integer('id_obat')->unsigned();             
            $table->string('nomor_batch');
            $table->dateTime('waktu_masuk'); 

            $table->foreign(['id_obat','nomor_batch','waktu_masuk'])
                  ->references(['id_obat','nomor_batch','waktu_masuk'])->on('obat_masuk')
                  ->onDelete('restrict');
				  
			$table->dateTime('waktu_pindah');			
			$table->integer('jumlah');	
			$table->string('keterangan');	
			
			$table->integer('tujuan_obat')->unsigned();						
			$table->foreign('tujuan_obat')
				  ->references('id')->on('lokasi_obat')
                  ->onDelete('restrict');
				  
            $table->timestamps();			
			
			$table->primary(['id_obat', 'nomor_batch', 'waktu_pindah']); // Yakin?
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obat_pindah');
    }
}
