<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObatMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obat_masuk', function (Blueprint $table) {
            // $table->increments('id');
			
			$table->integer('id_obat')->unsigned();			
			$table->foreign('id_obat')
				  ->references('id')->on('obat')
                  ->onDelete('restrict');
				  
			$table->string('nomor_batch');
			$table->dateTime('waktu_masuk');						
			$table->integer('jumlah');	
			$table->decimal('harga_beli_satuan', 12, 2);
			$table->dateTime('kadaluarsa');				
			
			$table->integer('asal_obat')->unsigned();
			$table->foreign('asal_obat')
				  ->references('id')->on('lokasi_obat')
                  ->onDelete('restrict');
				  
            $table->timestamps();
			
			$table->primary(['id_obat', 'nomor_batch', 'waktu_masuk']); // Yakin?
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obat_masuk');
    }
}
