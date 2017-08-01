<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJenisObatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis_obat', function (Blueprint $table) {
            $table->increments('id');
			$table->string('merek_obat');			
			$table->string('nama_generik');	
            $table->string('pembuat');
			$table->string('golongan');				
			$table->string('satuan');				
			$table->decimal('harga_jual_satuan', 12, 2);
            $table->boolean('dicover_bpjs');
            $table->boolean('special_medicine');
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
        Schema::dropIfExists('jenis_obat');
    }
}
