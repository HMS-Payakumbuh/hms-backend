<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObatEceranItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obat_eceran_item', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_obat_eceran')->unsigned();
            $table->foreign('id_obat_eceran')
                  ->references('id')->on('obat_eceran')
                  ->onDelete('restrict');    
            
            $table->integer('id_jenis_obat')->unsigned();
            $table->foreign('id_jenis_obat')
                  ->references('id')->on('jenis_obat')
                  ->onDelete('restrict');                        
                  
            $table->integer('id_stok_obat')->unsigned();
            $table->foreign('id_stok_obat')
                  ->references('id')->on('stok_obat')
                  ->onDelete('restrict');     

            $table->integer('id_pembayaran')->unsigned()->nullable();
            $table->foreign('id_pembayaran')
                  ->references('id')->on('pembayaran')
                  ->onDelete('restrict');
                    
            $table->integer('jumlah');  
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
        Schema::dropIfExists('obat_eceran_item');
    }
}
