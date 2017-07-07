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
            $table->integer('id_pasien')->unsigned()->nullable;
            $table->string('no_transaksi')->unique()->nullable();
            $table->string('no_sep')->nullable();
            $table->dateTime('waktu_masuk_pasien');
            $table->dateTime('waktu_perubahan_terakhir');
            $table->decimal('harga_total', 65, 2);
            $table->string('asuransi_pasien')->nullable();
            $table->integer('kode_jenis_pasien'); //1: pasien umum, 2: pasien asuransi
            $table->integer('jenis_rawat'); //1: rawat inap, 2: rawat jalan
            $table->integer('kelas_rawat'); //kelas perawatan saat pasien mendaftar
            $table->integer('status_naik_kelas'); //1: pasien tidak naik kelas, 2: pasien naik kelas
            $table->string('status'); //status transaksi (open/closed)

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
