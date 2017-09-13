<?php

use Illuminate\Database\Seeder;

class ObatPindahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('obat_pindah')->insert(array(
        	array('id_jenis_obat'=>1, 'id_stok_obat_asal'=>1, 'id_stok_obat_tujuan'=>73 ,'waktu_pindah'=>'2017-02-07 09:12:00', 'jumlah'=>20, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>2, 'id_stok_obat_asal'=>2, 'id_stok_obat_tujuan'=>74 ,'waktu_pindah'=>'2017-02-15 09:16:00', 'jumlah'=>10, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>3, 'id_stok_obat_asal'=>3, 'id_stok_obat_tujuan'=>75 ,'waktu_pindah'=>'2017-02-22 09:26:00', 'jumlah'=>80, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>4, 'id_stok_obat_asal'=>4, 'id_stok_obat_tujuan'=>76 ,'waktu_pindah'=>'2017-03-06 09:32:00', 'jumlah'=>80, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>5, 'id_stok_obat_asal'=>5, 'id_stok_obat_tujuan'=>77 ,'waktu_pindah'=>'2017-03-07 09:42:00', 'jumlah'=>60, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>6, 'id_stok_obat_asal'=>6, 'id_stok_obat_tujuan'=>78 ,'waktu_pindah'=>'2017-03-21 09:46:00', 'jumlah'=>60, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>7, 'id_stok_obat_asal'=>7, 'id_stok_obat_tujuan'=>79 ,'waktu_pindah'=>'2017-04-15 10:02:00', 'jumlah'=>50, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>8, 'id_stok_obat_asal'=>8, 'id_stok_obat_tujuan'=>80 ,'waktu_pindah'=>'2017-04-28 10:08:00', 'jumlah'=>10, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>9, 'id_stok_obat_asal'=>9, 'id_stok_obat_tujuan'=>81 ,'waktu_pindah'=>'2017-05-05 10:10:00', 'jumlah'=>30, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>10, 'id_stok_obat_asal'=>10, 'id_stok_obat_tujuan'=>82 ,'waktu_pindah'=>'2017-05-16 10:16:00', 'jumlah'=>20, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>11, 'id_stok_obat_asal'=>11, 'id_stok_obat_tujuan'=>83 ,'waktu_pindah'=>'2017-05-19 10:22:00', 'jumlah'=>10, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>12, 'id_stok_obat_asal'=>12, 'id_stok_obat_tujuan'=>84 ,'waktu_pindah'=>'2017-05-29 10:36:00', 'jumlah'=>30, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>13, 'id_stok_obat_asal'=>13, 'id_stok_obat_tujuan'=>85 ,'waktu_pindah'=>'2017-06-05 10:38:00', 'jumlah'=>10, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>14, 'id_stok_obat_asal'=>14, 'id_stok_obat_tujuan'=>86 ,'waktu_pindah'=>'2017-06-23 10:44:00', 'jumlah'=>20, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>15, 'id_stok_obat_asal'=>15, 'id_stok_obat_tujuan'=>87 ,'waktu_pindah'=>'2017-07-05 10:48:00', 'jumlah'=>30, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>16, 'id_stok_obat_asal'=>16, 'id_stok_obat_tujuan'=>88 ,'waktu_pindah'=>'2017-06-18 10:56:00', 'jumlah'=>40, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>17, 'id_stok_obat_asal'=>17, 'id_stok_obat_tujuan'=>89 ,'waktu_pindah'=>'2017-06-20 10:58:00', 'jumlah'=>20, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>18, 'id_stok_obat_asal'=>18, 'id_stok_obat_tujuan'=>90 ,'waktu_pindah'=>'2017-06-25 11:00:00', 'jumlah'=>30, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>19, 'id_stok_obat_asal'=>19, 'id_stok_obat_tujuan'=>91 ,'waktu_pindah'=>'2017-06-27 11:02:00', 'jumlah'=>40, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>20, 'id_stok_obat_asal'=>20, 'id_stok_obat_tujuan'=>92 ,'waktu_pindah'=>'2017-07-02 11:06:00', 'jumlah'=>10, 'asal'=>1, 'tujuan'=>2),
        	array('id_jenis_obat'=>1, 'id_stok_obat_asal'=>1, 'id_stok_obat_tujuan'=>93 ,'waktu_pindah'=>'2017-02-07 09:12:00', 'jumlah'=>5, 'asal'=>1, 'tujuan'=>3),
        	array('id_jenis_obat'=>2, 'id_stok_obat_asal'=>2, 'id_stok_obat_tujuan'=>94 ,'waktu_pindah'=>'2017-02-15 09:16:00', 'jumlah'=>5, 'asal'=>1, 'tujuan'=>3),
        	array('id_jenis_obat'=>3, 'id_stok_obat_asal'=>3, 'id_stok_obat_tujuan'=>95 ,'waktu_pindah'=>'2017-02-22 09:26:00', 'jumlah'=>5, 'asal'=>1, 'tujuan'=>3),
        	array('id_jenis_obat'=>4, 'id_stok_obat_asal'=>4, 'id_stok_obat_tujuan'=>96 ,'waktu_pindah'=>'2017-03-06 09:32:00', 'jumlah'=>5, 'asal'=>1, 'tujuan'=>3),
        	array('id_jenis_obat'=>5, 'id_stok_obat_asal'=>5, 'id_stok_obat_tujuan'=>97 ,'waktu_pindah'=>'2017-03-07 09:42:00', 'jumlah'=>5, 'asal'=>1, 'tujuan'=>3),
        	array('id_jenis_obat'=>6, 'id_stok_obat_asal'=>6, 'id_stok_obat_tujuan'=>98 ,'waktu_pindah'=>'2017-03-21 09:46:00', 'jumlah'=>5, 'asal'=>1, 'tujuan'=>3),
        	array('id_jenis_obat'=>7, 'id_stok_obat_asal'=>7, 'id_stok_obat_tujuan'=>99 ,'waktu_pindah'=>'2017-04-15 10:02:00', 'jumlah'=>5, 'asal'=>1, 'tujuan'=>3),
        	array('id_jenis_obat'=>8, 'id_stok_obat_asal'=>8, 'id_stok_obat_tujuan'=>100 ,'waktu_pindah'=>'2017-04-28 10:08:00', 'jumlah'=>5, 'asal'=>1, 'tujuan'=>3),
        ));
    }
}
