<?php

use Illuminate\Database\Seeder;

class ObatMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('obat_masuk')->insert(array(
        	array('id_jenis_obat'=>1, 'id_stok_obat'=>1, 'waktu_masuk'=>'2017-01-07 09:12:00', 'jumlah'=>170, 'harga_beli_satuan'=>9100.00),
			array('id_jenis_obat'=>2, 'id_stok_obat'=>2, 'waktu_masuk'=>'2017-01-15 09:16:00', 'jumlah'=>110, 'harga_beli_satuan'=>11000.00),
			array('id_jenis_obat'=>3, 'id_stok_obat'=>3, 'waktu_masuk'=>'2017-01-22 09:26:00', 'jumlah'=>380, 'harga_beli_satuan'=>49000.00),
			array('id_jenis_obat'=>4, 'id_stok_obat'=>4, 'waktu_masuk'=>'2017-02-06 09:32:00', 'jumlah'=>480, 'harga_beli_satuan'=>1300.00),
			array('id_jenis_obat'=>5, 'id_stok_obat'=>5, 'waktu_masuk'=>'2017-02-07 09:42:00', 'jumlah'=>380, 'harga_beli_satuan'=>1400.00),
			array('id_jenis_obat'=>6, 'id_stok_obat'=>6, 'waktu_masuk'=>'2017-02-21 09:46:00', 'jumlah'=>310, 'harga_beli_satuan'=>1600.00),
			array('id_jenis_obat'=>7, 'id_stok_obat'=>7, 'waktu_masuk'=>'2017-03-15 10:02:00', 'jumlah'=>450, 'harga_beli_satuan'=>900.00),
			array('id_jenis_obat'=>8, 'id_stok_obat'=>8, 'waktu_masuk'=>'2017-03-28 10:08:00', 'jumlah'=>90, 'harga_beli_satuan'=>2700.00),
			array('id_jenis_obat'=>9, 'id_stok_obat'=>9, 'waktu_masuk'=>'2017-04-05 10:10:00', 'jumlah'=>230, 'harga_beli_satuan'=>470),
			array('id_jenis_obat'=>10, 'id_stok_obat'=>10, 'waktu_masuk'=>'2017-04-16 10:16:00', 'jumlah'=>320, 'harga_beli_satuan'=>450),
			array('id_jenis_obat'=>11, 'id_stok_obat'=>11, 'waktu_masuk'=>'2017-04-19 10:22:00', 'jumlah'=>30, 'harga_beli_satuan'=>6800.00),
			array('id_jenis_obat'=>12, 'id_stok_obat'=>12, 'waktu_masuk'=>'2017-04-29 10:36:00', 'jumlah'=>330, 'harga_beli_satuan'=>7400.00),
			array('id_jenis_obat'=>13, 'id_stok_obat'=>13, 'waktu_masuk'=>'2017-05-05 10:38:00', 'jumlah'=>20, 'harga_beli_satuan'=>6300.00),
			array('id_jenis_obat'=>14, 'id_stok_obat'=>14, 'waktu_masuk'=>'2017-05-23 10:44:00', 'jumlah'=>320, 'harga_beli_satuan'=>6300.00),
			array('id_jenis_obat'=>15, 'id_stok_obat'=>15, 'waktu_masuk'=>'2017-06-05 10:48:00', 'jumlah'=>180, 'harga_beli_satuan'=>9700.00),
			array('id_jenis_obat'=>16, 'id_stok_obat'=>16, 'waktu_masuk'=>'2017-06-18 10:56:00', 'jumlah'=>190, 'harga_beli_satuan'=>12200.00),
			array('id_jenis_obat'=>17, 'id_stok_obat'=>17, 'waktu_masuk'=>'2017-06-20 10:58:00', 'jumlah'=>420, 'harga_beli_satuan'=>700.00),
			array('id_jenis_obat'=>18, 'id_stok_obat'=>18, 'waktu_masuk'=>'2017-06-25 11:00:00', 'jumlah'=>280, 'harga_beli_satuan'=>1500.00),
			array('id_jenis_obat'=>19, 'id_stok_obat'=>19, 'waktu_masuk'=>'2017-06-27 11:02:00', 'jumlah'=>340, 'harga_beli_satuan'=>630),
			array('id_jenis_obat'=>20, 'id_stok_obat'=>20, 'waktu_masuk'=>'2017-07-02 11:06:00', 'jumlah'=>50, 'harga_beli_satuan'=>8000.00),
			array('id_jenis_obat'=>21, 'id_stok_obat'=>21, 'waktu_masuk'=>'2017-08-06 11:08:00', 'jumlah'=>150, 'harga_beli_satuan'=>5100.00),
			array('id_jenis_obat'=>22, 'id_stok_obat'=>22, 'waktu_masuk'=>'2017-08-23 11:20:00', 'jumlah'=>210, 'harga_beli_satuan'=>500.00),
			array('id_jenis_obat'=>23, 'id_stok_obat'=>23, 'waktu_masuk'=>'2017-08-24 11:22:00', 'jumlah'=>250, 'harga_beli_satuan'=>900.00),
			array('id_jenis_obat'=>24, 'id_stok_obat'=>24, 'waktu_masuk'=>'2017-08-30 11:24:00', 'jumlah'=>440, 'harga_beli_satuan'=>600.00),
			array('id_jenis_obat'=>25, 'id_stok_obat'=>25, 'waktu_masuk'=>'2017-09-10 11:26:00', 'jumlah'=>420, 'harga_beli_satuan'=>2100.00),
			array('id_jenis_obat'=>26, 'id_stok_obat'=>26, 'waktu_masuk'=>'2017-01-05 11:28:00', 'jumlah'=>270, 'harga_beli_satuan'=>4400.00),
			array('id_jenis_obat'=>27, 'id_stok_obat'=>27, 'waktu_masuk'=>'2017-01-17 11:30:00', 'jumlah'=>500, 'harga_beli_satuan'=>15500.00),
			array('id_jenis_obat'=>28, 'id_stok_obat'=>28, 'waktu_masuk'=>'2017-01-24 11:34:00', 'jumlah'=>310, 'harga_beli_satuan'=>39200.00),
			array('id_jenis_obat'=>29, 'id_stok_obat'=>29, 'waktu_masuk'=>'2017-02-15 11:38:00', 'jumlah'=>260, 'harga_beli_satuan'=>400.00),
			array('id_jenis_obat'=>30, 'id_stok_obat'=>30, 'waktu_masuk'=>'2017-02-19 11:40:00', 'jumlah'=>500, 'harga_beli_satuan'=>3100.00),
			array('id_jenis_obat'=>31, 'id_stok_obat'=>31, 'waktu_masuk'=>'2017-03-05 11:50:00', 'jumlah'=>160, 'harga_beli_satuan'=>350),
			array('id_jenis_obat'=>32, 'id_stok_obat'=>32, 'waktu_masuk'=>'2017-03-16 11:54:00', 'jumlah'=>180, 'harga_beli_satuan'=>370),
			array('id_jenis_obat'=>33, 'id_stok_obat'=>33, 'waktu_masuk'=>'2017-03-18 11:56:00', 'jumlah'=>380, 'harga_beli_satuan'=>200.00),
			array('id_jenis_obat'=>34, 'id_stok_obat'=>34, 'waktu_masuk'=>'2017-03-20 12:02:00', 'jumlah'=>390, 'harga_beli_satuan'=>500.00),
			array('id_jenis_obat'=>35, 'id_stok_obat'=>35, 'waktu_masuk'=>'2017-03-22 12:12:00', 'jumlah'=>440, 'harga_beli_satuan'=>1100.00),
			array('id_jenis_obat'=>36, 'id_stok_obat'=>36, 'waktu_masuk'=>'2017-03-24 12:28:00', 'jumlah'=>210, 'harga_beli_satuan'=>220),
			array('id_jenis_obat'=>37, 'id_stok_obat'=>37, 'waktu_masuk'=>'2017-03-31 12:30:00', 'jumlah'=>280, 'harga_beli_satuan'=>3300.00),
			array('id_jenis_obat'=>38, 'id_stok_obat'=>38, 'waktu_masuk'=>'2017-04-08 12:42:00', 'jumlah'=>460, 'harga_beli_satuan'=>7100.00),
			array('id_jenis_obat'=>39, 'id_stok_obat'=>39, 'waktu_masuk'=>'2017-04-10 12:52:00', 'jumlah'=>250, 'harga_beli_satuan'=>8800.00),
			array('id_jenis_obat'=>40, 'id_stok_obat'=>40, 'waktu_masuk'=>'2017-04-11 13:02:00', 'jumlah'=>230, 'harga_beli_satuan'=>16400.00),
			array('id_jenis_obat'=>41, 'id_stok_obat'=>41, 'waktu_masuk'=>'2017-05-14 13:16:00', 'jumlah'=>270, 'harga_beli_satuan'=>2400.00),
			array('id_jenis_obat'=>42, 'id_stok_obat'=>42, 'waktu_masuk'=>'2017-05-30 13:28:00', 'jumlah'=>360, 'harga_beli_satuan'=>520),
			array('id_jenis_obat'=>43, 'id_stok_obat'=>43, 'waktu_masuk'=>'2017-06-03 13:30:00', 'jumlah'=>470, 'harga_beli_satuan'=>360),
			array('id_jenis_obat'=>44, 'id_stok_obat'=>44, 'waktu_masuk'=>'2017-06-04 13:48:00', 'jumlah'=>120, 'harga_beli_satuan'=>660),
			array('id_jenis_obat'=>45, 'id_stok_obat'=>45, 'waktu_masuk'=>'2017-06-10 14:00:00', 'jumlah'=>30, 'harga_beli_satuan'=>720),
			array('id_jenis_obat'=>46, 'id_stok_obat'=>46, 'waktu_masuk'=>'2017-06-19 14:10:00', 'jumlah'=>250, 'harga_beli_satuan'=>410),
			array('id_jenis_obat'=>47, 'id_stok_obat'=>47, 'waktu_masuk'=>'2017-06-20 14:12:00', 'jumlah'=>420, 'harga_beli_satuan'=>4300.00),
			array('id_jenis_obat'=>48, 'id_stok_obat'=>48, 'waktu_masuk'=>'2017-06-27 14:14:00', 'jumlah'=>470, 'harga_beli_satuan'=>5000.00),
			array('id_jenis_obat'=>49, 'id_stok_obat'=>49, 'waktu_masuk'=>'2017-07-15 14:16:00', 'jumlah'=>60, 'harga_beli_satuan'=>7900.00),
			array('id_jenis_obat'=>50, 'id_stok_obat'=>50, 'waktu_masuk'=>'2017-07-28 14:18:00', 'jumlah'=>100, 'harga_beli_satuan'=>9200.00),
			array('id_jenis_obat'=>51, 'id_stok_obat'=>51, 'waktu_masuk'=>'2017-01-08 14:24:00', 'jumlah'=>260, 'harga_beli_satuan'=>7500.00),
			array('id_jenis_obat'=>52, 'id_stok_obat'=>52, 'waktu_masuk'=>'2017-01-11 14:32:00', 'jumlah'=>20, 'harga_beli_satuan'=>7800.00),
			array('id_jenis_obat'=>53, 'id_stok_obat'=>53, 'waktu_masuk'=>'2017-02-11 14:40:00', 'jumlah'=>170, 'harga_beli_satuan'=>8800.00),
			array('id_jenis_obat'=>54, 'id_stok_obat'=>54, 'waktu_masuk'=>'2017-02-13 14:42:00', 'jumlah'=>100, 'harga_beli_satuan'=>100.00),
			array('id_jenis_obat'=>55, 'id_stok_obat'=>55, 'waktu_masuk'=>'2017-03-02 14:46:00', 'jumlah'=>380, 'harga_beli_satuan'=>9400.00),
			array('id_jenis_obat'=>56, 'id_stok_obat'=>56, 'waktu_masuk'=>'2017-03-03 14:52:00', 'jumlah'=>410, 'harga_beli_satuan'=>3600.00),
			array('id_jenis_obat'=>57, 'id_stok_obat'=>57, 'waktu_masuk'=>'2017-03-20 15:04:00', 'jumlah'=>490, 'harga_beli_satuan'=>8100.00),
			array('id_jenis_obat'=>58, 'id_stok_obat'=>58, 'waktu_masuk'=>'2017-03-21 15:14:00', 'jumlah'=>380, 'harga_beli_satuan'=>8500.00),
			array('id_jenis_obat'=>59, 'id_stok_obat'=>59, 'waktu_masuk'=>'2017-03-23 15:18:00', 'jumlah'=>270, 'harga_beli_satuan'=>14200.00),
			array('id_jenis_obat'=>60, 'id_stok_obat'=>60, 'waktu_masuk'=>'2017-03-29 15:36:00', 'jumlah'=>10, 'harga_beli_satuan'=>22100.00),
			array('id_jenis_obat'=>61, 'id_stok_obat'=>61, 'waktu_masuk'=>'2017-04-03 15:46:00', 'jumlah'=>100, 'harga_beli_satuan'=>7300.00),
			array('id_jenis_obat'=>62, 'id_stok_obat'=>62, 'waktu_masuk'=>'2017-04-06 15:54:00', 'jumlah'=>260, 'harga_beli_satuan'=>19000.00),
			array('id_jenis_obat'=>63, 'id_stok_obat'=>63, 'waktu_masuk'=>'2017-04-07 15:56:00', 'jumlah'=>450, 'harga_beli_satuan'=>24300.00),
			array('id_jenis_obat'=>64, 'id_stok_obat'=>64, 'waktu_masuk'=>'2017-05-02 16:06:00', 'jumlah'=>490, 'harga_beli_satuan'=>17200.00),
			array('id_jenis_obat'=>65, 'id_stok_obat'=>65, 'waktu_masuk'=>'2017-05-09 16:08:00', 'jumlah'=>400, 'harga_beli_satuan'=>35000.00),
			array('id_jenis_obat'=>66, 'id_stok_obat'=>66, 'waktu_masuk'=>'2017-05-16 16:10:00', 'jumlah'=>290, 'harga_beli_satuan'=>37000.00),
			array('id_jenis_obat'=>67, 'id_stok_obat'=>67, 'waktu_masuk'=>'2017-05-26 16:18:00', 'jumlah'=>450, 'harga_beli_satuan'=>1600.00),
			array('id_jenis_obat'=>68, 'id_stok_obat'=>68, 'waktu_masuk'=>'2017-05-27 16:38:00', 'jumlah'=>90, 'harga_beli_satuan'=>3200.00),
			array('id_jenis_obat'=>69, 'id_stok_obat'=>69, 'waktu_masuk'=>'2017-06-22 16:42:00', 'jumlah'=>140, 'harga_beli_satuan'=>5600.00),
			array('id_jenis_obat'=>70, 'id_stok_obat'=>70, 'waktu_masuk'=>'2017-06-28 16:44:00', 'jumlah'=>300, 'harga_beli_satuan'=>700.00),
			array('id_jenis_obat'=>71, 'id_stok_obat'=>71, 'waktu_masuk'=>'2017-07-06 16:48:00', 'jumlah'=>210, 'harga_beli_satuan'=>800.00),
			array('id_jenis_obat'=>72, 'id_stok_obat'=>72, 'waktu_masuk'=>'2017-07-17 16:52:00', 'jumlah'=>500, 'harga_beli_satuan'=>1200.00)
        ));
    }
}
