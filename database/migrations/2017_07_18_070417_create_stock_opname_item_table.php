<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockOpnameItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_opname_item', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_stock_opname')->unsigned();                     
            $table->foreign('id_stock_opname')
                  ->references('id')->on('stock_opname')
                  ->onDelete('restrict');
            
            $table->integer('id_stok_obat')->unsigned();           
            $table->foreign('id_stok_obat')
                  ->references('id')->on('stok_obat')
                  ->onDelete('restrict');
            
            $table->integer('id_jenis_obat')->unsigned();           
            $table->foreign('id_jenis_obat')
                  ->references('id')->on('jenis_obat')
                  ->onDelete('restrict');

            $table->integer('id_obat_masuk')->unsigned();
            $table->foreign('id_obat_masuk')
                  ->references('id')->on('obat_masuk')
                  ->onDelete('restrict');

            $table->integer('jumlah_awal');  
            $table->integer('jumlah_akhir'); 
            $table->integer('jumlah_sebenarnya');  

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
        Schema::dropIfExists('stock_opname_item');
    }
}
