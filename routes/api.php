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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

Route::resource('pasien', 'PasienController', ['except' => [
  'edit', 'create'
]]);

Route::resource('rekam_medis', 'RekamMedisController', ['except' => [
  'edit', 'update', 'show', 'create'
]]);
Route::get('rekam_medis/{id_pasien}', 'RekamMedisController@show');
Route::put('rekam_medis/{id_pasien}/{tanggal_waktu}', 'RekamMedisController@update');

Route::resource('antrian_sms', 'AntrianSMSController', ['except' => [
  'edit', 'create', 'store'
]]);
Route::post('antrian_sms/parse_message', 'AntrianSMSController@parseMessage');

Route::resource('antrian_front_office', 'AntrianFrontOfficeController', ['except' => [
  'edit', 'show', 'cleanup', 'create', 'update', 'delete'
]]);
Route::get('antrian_front_office/cleanup', 'AntrianFrontOfficeController@cleanup');
Route::get('antrian_front_office/{kategori_antrian}', 'AntrianFrontOfficeController@show');
Route::put('antrian_front_office/{nama_layanan}/{no_antrian}', 'AntrianFrontOfficeController@update');
Route::delete('antrian_front_office/{nama_layanan}/{no_antrian}', 'AntrianFrontOfficeController@destroy');

Route::resource('antrian', 'AntrianController', ['except' => [
  'edit', 'show', 'create', 'update', 'delete'
]]);
Route::get('antrian/cleanup', 'AntrianController@cleanup');
Route::get('antrian/{nama_layanan}/status/{status}', 'AntrianController@getAntrianWithStatus');
Route::get('antrian/{nama_layanan}', 'AntrianController@show');
Route::put('antrian/{nama_layanan}/{no_antrian}', 'AntrianController@update');
Route::put('antrian/process/{id_transaksi}/{no_antrian}', 'AntrianController@processAntrian');
Route::delete('antrian/{nama_layanan}/{no_antrian}', 'AntrianController@destroy');

Route::post('bpjs', 'BpjsController@process');
Route::resource('transaksi', 'TransaksiController', ['except' => [
  'edit', 'show', 'create'
  ]]);
Route::get('transaksi/search_by_pasien', 'TransaksiController@searchByPasien');
Route::get('transaksi/latest/{id_pasien}', 'TransaksiController@getLatestOpenTransaksi');
Route::get('transaksi/{id}/bpjs', 'TransaksiController@getStatusBpjs');
Route::get('transaksi/search/{nama_pasien}', 'TransaksiController@getRecentTransaksi');
Route::get('transaksi/{id}/{field?}', 'TransaksiController@show');

Route::resource('rujukan', 'RujukanController', ['except' => [
  'edit', 'create'
]]);

Route::resource('klaim', 'KlaimController');
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

Route::resource('daftar_tindakan', 'DaftarTindakanController', ['except' => [
  'edit', 'create'
]]);

Route::get('tindakan/rekam_medis/{id_pasien}/{tanggal_waktu}', 'TindakanController@getTindakanOfRekamMedis');
Route::get('tindakan/hasil_lab/{nama_lab}/{kode_pasien}', 'TindakanController@getTindakanWithoutHasilLab');

Route::resource('tindakan', 'TindakanController', ['except' => [
  'edit', 'create', 'show', 'destroy'
]]);
Route::get('tindakan/{no_transaksi}/{no_tindakan?}', 'TindakanController@show');
Route::delete('tindakan/{no_transaksi}/{no_tindakan?}', 'TindakanController@destroy');

Route::resource('tindakan_operasi', 'TindakanOperasiController', ['except' => [
  'edit', 'create', 'show', 'update', 'destroy'
]]);
Route::get('tindakan_operasi/{pemakaianKamarOperasiId}', 'TindakanOperasiController@show');
Route::post('tindakan_operasi/{id_tindakan}', 'TindakanOperasiController@store');

Route::resource('poliklinik', 'PoliklinikController', ['except' => [
  'edit', 'create'
]]);

Route::resource('laboratorium', 'LaboratoriumController', ['except' => [
  'edit', 'create'
]]);

Route::get('hasil_lab/download/{path}', 'HasilLabController@download');
Route::get('hasil_lab/empty/{no_pegawai}', 'HasilLabController@getEmptyHasilLab');
Route::post('hasil_lab/upload/{id}', 'HasilLabController@upload');
Route::resource('hasil_lab', 'HasilLabController', ['except' => [
  'edit', 'create', 'getEmptyHasilLab', 'download', 'upload'
]]);

Route::resource('ambulans', 'AmbulansController', ['except' => [
  'edit', 'create'
]]);

Route::resource('tenaga_medis', 'TenagaMedisController', ['except' => [
  'edit', 'create'
]]);

Route::resource('dokter', 'DokterController', ['except' => [
  'edit', 'create', 'periksa'
]]);
Route::post('dokter/periksa', 'DokterController@periksa');

Route::get('jadwal_dokter/{nama_poli}/{np_dokter}/{tanggal}', 'JadwalDokterController@show');
Route::get('jadwal_dokter/{nama_poli}', 'JadwalDokterController@showAvailable');
Route::put('jadwal_dokter/{nama_poli}/{np_dokter}/{tanggal}', 'JadwalDokterController@update');
Route::delete('jadwal_dokter/{nama_poli}/{np_dokter}/{tanggal}', 'JadwalDokterController@destroy');

Route::resource('jadwal_dokter', 'JadwalDokterController', ['except' => [
  'edit', 'create', 'show', 'update', 'destroy'
]]);

Route::resource('rawatinap', 'KamarRawatInapController', ['except' => [
  'edit', 'create'
]]);

Route::resource('rawatinap', 'KamarRawatInapController', ['except' => [
  'edit', 'create'
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

Route::resource('pemeriksaan', 'PemakaianKamarRawatinapController', ['except' => [
  'edit', 'create'
]]);

Route::post('pemakaiankamarrawatinap/booking/{tanggal}', 'PemakaianKamarRawatInapController@storeBooked');

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
Route::put('rawatinap/booking/{id}', 'PemakaianKamarRawatInapController@masuk');\
Route::get('rawatinap/booking/{tanggal}/now', 'KamarRawatInapController@getAvailableKamarMinusNow');
Route::get('rawatinap/booking/{tanggal}/booked', 'KamarRawatInapController@getAvailableKamarMinusBooked');

Route::put('tempattidur/{no_kamar}/{no_tempat_tidur}', 'TempatTidurController@update');

// Route::get('resep/search_by_transaksi', 'ResepController@searchByTransaksi');
Route::get('resep/rekam_medis/{id_pasien}/{tanggal_waktu}', 'ResepController@getResepOfRekamMedis');
Route::get('resep/search_by_pasien', 'ResepController@searchByPasien');
// Route::get('resep/search_by_pasien_and_tanggal', 'ResepController@searchByPasienAndTanggal');
Route::resource('resep', 'ResepController', ['except' => [
  'edit', 'show', 'create'
]]);
Route::resource('resep_item', 'ResepItemController');
Route::resource('racikan_item', 'RacikanItemController');

Route::get('jenis_obat/search', 'JenisObatController@search');
Route::resource('jenis_obat', 'JenisObatController');

Route::resource('lokasi_obat', 'LokasiObatController');

Route::get('obat_masuk/export', 'ObatMasukController@export');
Route::get('obat_masuk/today/{id_stok_obat}', 'ObatMasukController@getTodayObatMasukByStok');
Route::get('obat_masuk/search', 'ObatMasukController@search');
Route::resource('obat_masuk', 'ObatMasukController');

Route::get('stok_obat/export', 'StokObatController@export');
Route::get('stok_obat/search_by_jenis_obat_and_batch', 'StokObatController@searchByJenisObatAndBatch');
Route::get('stok_obat/search_by_location_type', 'StokObatController@searchByLocationType');
Route::get('stok_obat/search_by_location', 'StokObatController@searchByLocation');
Route::resource('stok_obat', 'StokObatController');

Route::get('obat_pindah/export', 'ObatPindahController@export');
Route::get('obat_pindah/today/keluar/{id_stok_obat}', 'ObatPindahController@getTodayObatPindahKeluarByStok');
Route::get('obat_pindah/today/masuk/{id_stok_obat}', 'ObatPindahController@getTodayObatPindahMasukByStok');
Route::resource('obat_pindah', 'ObatPindahController');

Route::get('obat_rusak/export', 'ObatRusakController@export');
Route::get('obat_rusak/today/{id_stok_obat}', 'ObatRusakController@getTodayObatRusakByStok');
Route::resource('obat_rusak', 'ObatRusakController');

Route::get('obat_tebus/export', 'ObatTebusController@export');
Route::get('obat_tebus/today/{id_stok_obat}', 'ObatTebusController@getTodayObatTebusByStok');
Route::resource('obat_tebus', 'ObatTebusController');

Route::get('obat_tindakan/export', 'ObatTindakanController@export');
Route::get('obat_tindakan/today/{id_stok_obat}', 'ObatTindakanController@getTodayObatTindakanByStok');
Route::resource('obat_tindakan', 'ObatTindakanController');

Route::get('obat_eceran/export', 'ObatEceranController@export');
Route::get('obat_eceran/today/{id_stok_obat}', 'ObatEceranController@getTodayObatEceranByStok');
Route::resource('obat_eceran', 'ObatEceranController');

Route::get('stock_opname/search_by_location', 'StockOpnameController@searchByLocation');
Route::resource('stock_opname', 'StockOpnameController');
