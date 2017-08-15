<?php

use Illuminate\Database\Seeder;

class DokterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('dokter')->insert(array(
        array('no_pegawai'=>'D001', 'spesialis'=>'Jantung'),
        array('no_pegawai'=>'D002', 'spesialis'=>'Saraf')
      ));
    }
}
