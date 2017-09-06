<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'Auth\AuthController@login');
Route::post('register', 'Auth\AuthController@register');
Route::post('update_user_kategori', 'Auth\AuthController@update_user_kategori');
Route::group(['middleware' => 'jwt.auth'], function () {
  Route::get('get_user_details', 'Auth\AuthController@get_user_details');


  Route::get('ambulans/available', 'AmbulansController@getAvailable');
  Route::resource('ambulans', 'AmbulansController', ['except' => [
    'edit', 'create'
  ]]);

  Route::resource('daftar_tindakan', 'DaftarTindakanController', ['except' => [
    'edit', 'create'
  ]]);
  
  Route::get('tindakan/rekam_medis/{id_pasien}/{tanggal_waktu}', 'TindakanController@getTindakanOfRekamMedis');
  Route::get('tindakan/hasil_lab/{nama_lab}', 'TindakanController@getTindakanWithoutHasilLab');
  Route::get('tindakan/no_ambulans', 'TindakanController@getTindakanWithoutAmbulans');

  Route::get('tindakan/{no_transaksi}/{no_tindakan?}', 'TindakanController@show');
  Route::delete('tindakan/{no_transaksi}/{no_tindakan?}', 'TindakanController@destroy');
  
  Route::resource('tindakan', 'TindakanController', ['except' => [
    'edit', 'create', 'show', 'destroy'
  ]]);

  Route::get('hasil_lab/empty/{no_pegawai}', 'HasilLabController@getEmptyHasilLab');
  Route::get('hasil_lab/download/{path}', 'HasilLabController@download');
  Route::post('hasil_lab/upload/{id}', 'HasilLabController@upload');
  Route::resource('hasil_lab', 'HasilLabController', ['except' => [
    'edit', 'create', 'getEmptyHasilLab', 'download', 'upload'
  ]]);

  Route::resource('dokter', 'DokterController', ['except' => [
    'edit', 'create', 'periksa', 'getAllDokterOfSpesialis'
  ]]);
  Route::get('dokter/{spesialis}', 'DokterController@getAllDokterOfSpesialis');
  Route::post('dokter/periksa', 'DokterController@periksa');  


  Route::resource('pasien', 'PasienController', ['except' => [
    'edit', 'create'
  ]]);

  Route::resource('catatan_kematian', 'CatatanKematianController', ['except' => [
    'edit', 'create'
  ]]);

  Route::resource('rekam_medis', 'RekamMedisController', ['except' => [
    'edit', 'update', 'show', 'create'
  ]]);
  Route::get('rekam_medis/{id_pasien}', 'RekamMedisController@show');
  Route::put('rekam_medis/{id_pasien}/{tanggal_waktu}', 'RekamMedisController@update');

  Route::resource('rekam_medis_eksternal', 'RekamMedisEksternalController', ['except' => [
    'edit', 'show', 'create'
  ]]);
  Route::get('rekam_medis_eksternal/import/{kode_pasien}/{no_rujukan}', 'RekamMedisEksternalController@getEksternalRekamMedis');
  Route::get('rekam_medis_eksternal/{id_pasien}', 'RekamMedisEksternalController@show');

  Route::get('transaksi/export', 'TransaksiController@export');
  Route::resource('transaksi', 'TransaksiController', ['except' => [
    'edit', 'create'
    ]]);

  Route::get('transaksi/latest/{id_pasien}', 'TransaksiController@getLatestOpenTransaksi');
  Route::resource('transaksi_eksternal', 'TransaksiEksternalController', ['except' => [
    'edit', 'create'
    ]]);
  Route::get('transaksi/search_by_pasien', 'TransaksiController@searchByPasien');

  Route::get('transaksi/{id}/bpjs', 'TransaksiController@getStatusBpjs');
  Route::get('transaksi/search/{nama_pasien}', 'TransaksiController@getRecentTransaksi');
  Route::get('transaksi/{id}/{field?}', 'TransaksiController@show');
  Route::get('klaim/export', 'KlaimController@export');
  Route::resource('klaim', 'KlaimController');
  Route::get('pembayaran/export', 'PembayaranController@export');
  Route::resource('pembayaran', 'PembayaranController');

  // Route::get('resep/search_by_transaksi', 'ResepController@searchByTransaksi');
  Route::get('resep/rekam_medis/{id_pasien}/{tanggal_waktu}', 'ResepController@getResepOfRekamMedis');
  Route::get('resep/search_by_pasien', 'ResepController@searchByPasien');
    
  Route::resource('resep', 'ResepController', ['except' => [
    'edit', 'create'
  ]]);
  Route::resource('resep_item', 'ResepItemController');
  Route::resource('racikan_item', 'RacikanItemController');

  Route::get('jenis_obat/search', 'JenisObatController@search');
  Route::resource('jenis_obat', 'JenisObatController');

  Route::resource('lokasi_obat', 'LokasiObatController');

  Route::get('obat_masuk/search_by_time', 'ObatMasukController@getObatMasukByTime');
  Route::get('obat_masuk/search', 'ObatMasukController@search');
  Route::resource('obat_masuk', 'ObatMasukController');

  Route::get('stok_obat/search_by_jenis_obat_and_batch', 'StokObatController@searchByJenisObatAndBatch');
  Route::get('stok_obat/search_by_location_type', 'StokObatController@searchByLocationType');
  Route::get('stok_obat/search_by_location', 'StokObatController@searchByLocation');
  Route::resource('stok_obat', 'StokObatController');

  Route::get('obat_pindah/search_by_time/keluar', 'ObatPindahController@getObatPindahKeluarByTime');
  Route::get('obat_pindah/search_by_time/masuk', 'ObatPindahController@getObatPindahMasukByTime');
  Route::resource('obat_pindah', 'ObatPindahController');

  Route::get('obat_rusak/search_by_time', 'ObatRusakController@getObatRusakByTime');
  Route::resource('obat_rusak', 'ObatRusakController');
});

Route::get('rekam_medis/eksternal/{no_rujukan}/{asal_rujukan}', 'RekamMedisController@getForExternal');

Route::post('antrian_sms/parse_message', 'AntrianSMSController@parseMessage');

Route::resource('antrian_front_office', 'AntrianFrontOfficeController', ['except' => [
  'edit', 'show', 'cleanup', 'create', 'update', 'delete'
]]);
Route::get('antrian_front_office/cleanup', 'AntrianFrontOfficeController@cleanup');
Route::get('antrian_front_office/update_sms', 'AntrianFrontOfficeController@updateAntrianSMS');
Route::get('antrian_front_office/{kategori_antrian}', 'AntrianFrontOfficeController@show');
Route::get('antrian_front_office/sms/{kategori_antrian}', 'AntrianFrontOfficeController@showAntrianSMS');
Route::put('antrian_front_office/{nama_layanan}/{no_antrian}', 'AntrianFrontOfficeController@update');
Route::delete('antrian_front_office/{nama_layanan}/{no_antrian}', 'AntrianFrontOfficeController@destroy');

Route::resource('antrian', 'AntrianController', ['except' => [
  'edit', 'show', 'create', 'update', 'delete'
]]);
Route::get('antrian/cleanup', 'AntrianController@cleanup');
Route::get('antrian/{nama_layanan}/status/{status}', 'AntrianController@getAntrianWithStatus');
Route::get('antrian/{nama_layanan}', 'AntrianController@show');
Route::put('antrian/{id_transaksi}/{no_antrian}', 'AntrianController@update');
Route::put('antrian/process/{id_transaksi}/{no_antrian}', 'AntrianController@processAntrian');
Route::delete('antrian/{id_transaksi}/{no_antrian}', 'AntrianController@destroy');

Route::get('sep/{no_rujukan}', 'SepController@insertSEP');
Route::get('sep/rujukan/{no_rujukan}', 'SepController@getRujukan');
Route::get('sep/peserta/{no_kartu}', 'SepController@getPeserta');

Route::resource('rujukan', 'RujukanController', ['except' => [
  'edit', 'create'
]]);

Route::get('klaim/export', 'KlaimController@export');
Route::resource('klaim', 'KlaimController');
Route::get('pembayaran/export', 'PembayaranController@export');
Route::resource('pembayaran', 'PembayaranController');
Route::resource('asuransi', 'AsuransiController');
Route::get('asuransi/search/{id_pasien}', 'AsuransiController@getAsuransiByIdPasien');

Route::resource('setting_bpjs', 'SettingBpjsController', ['except' => [
  'edit', 'create'
]]);

Route::resource('jaminan', 'JaminanController', ['except' => [
  'edit', 'create'
]]);

Route::resource('cob', 'CobController', ['except' => [
  'edit', 'create'
]]);

Route::resource('daftar_diagnosis', 'DaftarDiagnosisController', ['except' => [
  'edit', 'create'
]]);

Route::resource('diagnosis', 'DiagnosisController', ['except' => [
  'edit', 'show', 'create'
]]);
Route::get('diagnosis/{id_pasien}', 'DiagnosisController@getDiagnosisOfPasien');
Route::get('diagnosis/rekam_medis/{id_pasien}/{tanggal_waktu}', 'DiagnosisController@getDiagnosisOfRekamMedis');

Route::resource('tindakan_operasi', 'TindakanOperasiController', ['except' => [
  'edit', 'create'
]]);
Route::get('tindakan_operasi/{pemakaianKamarOperasiId}', 'TindakanOperasiController@show');
Route::get('tindakan_operasi/id/{id}', 'TindakanController@getTindakanById');
Route::post('tindakan_operasi/{id_tindakan}', 'TindakanOperasiController@store');

Route::resource('poliklinik', 'PoliklinikController', ['except' => [
  'edit', 'create'
]]);

Route::resource('laboratorium', 'LaboratoriumController', ['except' => [
  'edit', 'create'
]]);

Route::resource('tenaga_medis', 'TenagaMedisController', ['except' => [
  'edit', 'create'
]]);

Route::get('jadwal_dokter/{nama_poli}/{np_dokter}/{tanggal}', 'JadwalDokterController@show');
Route::get('jadwal_dokter/{nama_poli}', 'JadwalDokterController@showAvailable');
Route::put('jadwal_dokter/{nama_poli}/{np_dokter}/{tanggal}', 'JadwalDokterController@update');
Route::delete('jadwal_dokter/{nama_poli}/{np_dokter}/{tanggal}', 'JadwalDokterController@destroy');

Route::resource('jadwal_dokter', 'JadwalDokterController', ['except' => [
  'edit', 'create', 'show', 'update', 'destroy'
]]);


Route::resource('pemakaiankamaroperasi', 'PemakaianKamarOperasiController', ['except' => [
  'edit', 'create'
]]);

Route::resource('pemakaiankamarjenazah', 'PemakaianKamarJenazahController', ['except' => [
  'edit', 'create'
]]);

Route::resource('pemakaiankamarrawatinap', 'PemakaianKamarRawatinapController', ['except' => [
  'edit', 'create'
]]);

Route::resource('jasa_dokter_rawat_inap', 'JasaDokterRawatinapController', ['except' => [
  'edit', 'create'
]]);

Route::post('jasa_dokter_rawat_inap/{idPemakaian}', 'JasaDokterRawatinapController@store');
Route::get('jasa_dokter_rawat_inap/pemakaian/{idPemakaian}', 'JasaDokterRawatinapController@getJasaDokterByPemakaian');

Route::post('pemakaiankamarrawatinap/booking/{tanggal}', 'PemakaianKamarRawatInapController@storeBooked');
Route::post('pemakaiankamaroperasi/booking', 'PemakaianKamarOperasiController@storeBooked');
Route::put('pemakaiankamaroperasi/booking/masuk/{id}', 'PemakaianKamarOperasiController@masuk');
Route::put('pemakaiankamaroperasi/booking/keluar/{id}', 'PemakaianKamarOperasiController@keluar');

Route::resource('rawatinap', 'KamarRawatInapController', ['except' => [
  'edit', 'create'
]]);

Route::group(['middleware' => 'jwt.auth'], function () {



});

Route::put('pemakaiankamarrawatinap/{id}/{no_kamar}/{no_tempat_tidur}', 'PemakaianKamarRawatinapController@update');
Route::delete('pemakaiankamarrawatinap/{id}/{no_kamar}/{no_tempat_tidur}', 'PemakaianKamarRawatinapController@destroy');
Route::delete('pemakaiankamarrawatinap/booking/{id}', 'PemakaianKamarRawatinapController@destroyBooking');
Route::put('pemakaiankamarrawatinap/pindah/{id}', 'PemakaianKamarRawatinapController@pindahKamar');
Route::put('pemakaiankamarrawatinap/update/rawatinap/waktu_keluar/{id}', 'PemakaianKamarRawatinapController@updatePerkiraanWaktuKeluar');
Route::put('pemakaiankamarrawatinap/update/rawatinap/ventilator/icu/{id}', 'PemakaianKamarRawatinapController@tambahDurasiPemakaianVentilator');
Route::get('pemakaiankamarrawatinap/{id}', 'PemakaianKamarRawatinapController@show');
Route::get('pemakaiankamarrawatinap/search/booked/{no_kamar}', 'PemakaianKamarRawatinapController@getAllPemakaianKamarBookedByNoKamar');
Route::get('pemakaiankamarrawatinap/search/booked/{tanggal}/{no_kamar}', 'PemakaianKamarRawatinapController@getAllPemakaianKamarBookedWithTanggal');
Route::get('pemakaiankamarrawatinap/search/booked', 'PemakaianKamarRawatinapController@getAllPemakaianKamarBooked');
Route::get('pemakaiankamarrawatinap/now/{no_kamar}', 'PemakaianKamarRawatinapController@getAllPemakaianKamarByNoKamar');
Route::get('pemakaiankamarrawatinap/now/tenaga_medis/{no_pegawai}', 'PemakaianKamarRawatinapController@getAllPemakaianKamarByNoPegawai');
Route::get('pemakaiankamarrawatinap/dashboard/dokte', 'PemakaianKamarRawatinapController@indexForDokterDashboard');

Route::resource('kamaroperasi', 'KamarOperasiController', ['except' => [
  'edit', 'create'
]]);

Route::resource('kamarjenazah', 'KamarJenazahController', ['except' => [
  'edit', 'create'
]]);

Route::get('rawatinap/available/{tanggal}/booked', 'KamarRawatInapController@getAvailableKamarMinusBookedByNamaKamar');
Route::get('rawatinap/available/{tanggal}/now', 'KamarRawatInapController@getAvailableKamarMinusNowByNamaKamar');
Route::get('rawatinap/list/all', 'KamarRawatInapController@getAll');
Route::get('rawatinap/{no_kamar}', 'KamarRawatInapController@show');
Route::put('rawatinap/{no_kamar}', 'KamarRawatInapController@update');
Route::post('rawatinap/{no_kamar}', 'PemakaianKamarRawatInapController@store');
Route::put('rawatinap/booking/{id}', 'PemakaianKamarRawatInapController@masuk');
Route::get('rawatinap/booking/{tanggal}/now', 'KamarRawatInapController@getAvailableKamarMinusNow');
Route::get('rawatinap/booking/{tanggal}/booked', 'KamarRawatInapController@getAvailableKamarMinusBooked');

Route::put('tempattidur/{no_kamar}/{no_tempat_tidur}', 'TempatTidurController@update');

Route::get('obat_masuk/export', 'ObatMasukController@export');
Route::get('stok_obat/export/{lokasi}', 'StokObatController@export');
Route::get('obat_pindah/export', 'ObatPindahController@export');
Route::get('obat_rusak/export', 'ObatRusakController@export');
Route::get('obat_tebus/export', 'ObatTebusController@export');
Route::get('obat_tindakan/export', 'ObatTindakanController@export');
Route::get('obat_eceran/export', 'ObatEceranController@export');

Route::get('obat_tebus/search_by_time', 'ObatTebusController@getObatTebusByTime');
Route::resource('obat_tebus', 'ObatTebusController');

Route::get('obat_tindakan/search_by_time', 'ObatTindakanController@getObatTindakanByTime');
Route::resource('obat_tindakan', 'ObatTindakanController');

Route::get('obat_eceran/search_by_time', 'ObatEceranController@getObatEceranByTime');
Route::resource('obat_eceran', 'ObatEceranController');

Route::get('stock_opname/search_by_location', 'StockOpnameController@searchByLocation');
Route::get('stock_opname/latest_by_location', 'StockOpnameController@getLatestByLocation');
Route::resource('stock_opname', 'StockOpnameController');
