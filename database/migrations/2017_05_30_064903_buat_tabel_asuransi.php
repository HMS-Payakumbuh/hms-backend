<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTabelAsuransi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asuransi', function(Blueprint $table) {
            $table->string('no_anggota')->primary();
            $table->integer('id_pembayaran')->unsigned();
            $table->string('nama_asuransi');
            $table->string('status_klaim');
            $table->dateTime('waktu_klaim');
            $table->decimal('tarif_klaim', 65, 2);

            $table->foreign('id_pembayaran')
                    ->references('id')->on('pembayaran')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('asuransi');
    }
}
