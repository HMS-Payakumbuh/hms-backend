<?php

use Illuminate\Database\Seeder;

class TempatTidurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('tempat_tidur')->insert(array(
          array('no_kamar'=>'Melati-001', 'no_tempat_tidur'=>1, 'status'=>1),

          array('no_kamar'=>'Melati-002', 'no_tempat_tidur'=>1, 'status'=>1),
          array('no_kamar'=>'Melati-002', 'no_tempat_tidur'=>2, 'status'=>1),

          array('no_kamar'=>'Melati-003', 'no_tempat_tidur'=>1, 'status'=>1),
          array('no_kamar'=>'Melati-003', 'no_tempat_tidur'=>2, 'status'=>1),
          array('no_kamar'=>'Melati-003', 'no_tempat_tidur'=>3, 'status'=>1),
          array('no_kamar'=>'Melati-003', 'no_tempat_tidur'=>4, 'status'=>1),

          array('no_kamar'=>'Melati-004', 'no_tempat_tidur'=>1, 'status'=>1),
          array('no_kamar'=>'Melati-004', 'no_tempat_tidur'=>2, 'status'=>1),
          array('no_kamar'=>'Melati-004', 'no_tempat_tidur'=>3, 'status'=>1),
          array('no_kamar'=>'Melati-004', 'no_tempat_tidur'=>4, 'status'=>1),
          array('no_kamar'=>'Melati-004', 'no_tempat_tidur'=>5, 'status'=>1),
          array('no_kamar'=>'Melati-004', 'no_tempat_tidur'=>6, 'status'=>1),

          array('no_kamar'=>'Anggrek-001', 'no_tempat_tidur'=>1, 'status'=>1),

          array('no_kamar'=>'Anggrek-002', 'no_tempat_tidur'=>1, 'status'=>1),
          array('no_kamar'=>'Anggrek-002', 'no_tempat_tidur'=>2, 'status'=>1)
       ));
    }
}