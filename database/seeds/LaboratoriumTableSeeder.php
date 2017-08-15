<?php

use Illuminate\Database\Seeder;

class LaboratoriumTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('laboratorium')->insert(array(
        array('nama'=>'Lab Immunologi', 'kategori_antrian'=>'Lab'),
        array('nama'=>'Lab Hematologi', 'kategori_antrian'=>'Lab'),
        array('nama'=>'Radiologi', 'kategori_antrian'=>'Lab')
      ));
    }
}
