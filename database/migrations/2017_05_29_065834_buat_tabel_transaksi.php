<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTabelTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pasien')->unsigned();
            $table->dateTime('waktu_dibuat');
            $table->dateTime('waktu_pelunasan');
            $table->decimal('harga_total', 65, 2);
            $table->string('jenis_pasien');
            $table->string('status'); // lunas atau belum

            $table->timestamps();

            $table->foreign('id_pasien')
                    ->references('id')->on('pasien')
                    ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropForeign('transaksi_id_pasien_foreign');
        });
        Schema::dropIfExists('transaksi');
    }
}
