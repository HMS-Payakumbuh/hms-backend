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
      ));
    }
}
