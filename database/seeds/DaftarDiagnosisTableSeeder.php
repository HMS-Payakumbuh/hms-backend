<?php

use Illuminate\Database\Seeder;

class DaftarDiagnosisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('daftar_diagnosis')->insert(array(
        array('kode'=>'I50.1', 'nama'=>'Left ventricular failure'),
        array('kode'=>'I50.2', 'nama'=>'Systolic (congestive) heart failure'),
        array('kode'=>'I50.9', 'nama'=>'Heart failure, unspecified')
      ));
    }
}
