<?php

use Illuminate\Database\Seeder;

class KamarJenazahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('kamar_jenazah')->insert(array(
          array('no_kamar'=>'Jenazah-001'),
          array('no_kamar'=>'Jenazah-002')
       ));
    }
}