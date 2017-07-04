<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSettingBpjs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_bpjs', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('tarif_rs');
            $table->string('kd_tarif_rs');
            $table->string('coder_nik');
            $table->integer('add_payment_pct');

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
        Schema::dropIfExists('setting_bpjs');
    }
}
