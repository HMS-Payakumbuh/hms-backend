<?php

use Illuminate\Database\Seeder;

class AmbulansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('ambulans')->insert(array(
        array('nama'=>'Tidak ada ambulans', 'status'=>'Available'),
        array('nama'=>'D 8348 HR', 'status'=>'Available'),
        array('nama'=>'D 2170 KR', 'status'=>'Available'),
        array('nama'=>'D 0111 VN', 'status'=>'Available')
      ));
    }
}
