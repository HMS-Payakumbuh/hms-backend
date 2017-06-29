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
            $table->increments('id');
			
			$table->integer('id_jenis_obat')->unsigned();			
			$table->foreign('id_jenis_obat')
				  ->references('id')->on('jenis_obat')
                  ->onDelete('restrict');
				  
			$table->string('nomor_batch')->nullable();
			$table->dateTime('waktu_masuk');	// Atau pake timestampnya?					
			$table->integer('jumlah');	
			$table->decimal('harga_beli_satuan', 12, 2);
			$table->dateTime('kadaluarsa');			
            $table->string('barcode')->nullable();
				  
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
        Schema::dropIfExists('obat_masuk');
    }
}
