<?php

use Illuminate\Database\Seeder;

class KamarOperasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('kamar_operasi')->insert(array(
          array('no_kamar'=>'Operasi-001'),
          array('no_kamar'=>'Operasi-002')
       ));
    }
}