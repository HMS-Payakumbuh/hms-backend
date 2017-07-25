<?php

use Illuminate\Http\Request;
use App\Http\Controllers\LayananController;

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

Route::resource('pasien', 'PasienController', ['except' => [
  'edit', 'create'
]]);

Route::resource('rekam_medis', 'RekamMedisController', ['except' => [
  'edit', 'update', 'show', 'create'
]]);
Route::get('rekam_medis/{id_pasien}', 'RekamMedisController@show');
Route::put('rekam_medis/{id_pasien}/{tanggal_waktu}', 'RekamMedisController@update');

Route::resource('antrian_sms', 'AntrianSMSController', ['except' => [
  'edit', 'create'
]]);

Route::resource('antrian_front_office', 'AntrianFrontOfficeController', ['except' => [
  'edit', 'show', 'create', 'update', 'delete'
]]);
Route::get('antrian_front_office/{kategori_antrian}', 'AntrianFrontOfficeController@show');
Route::put('antrian_front_office/{nama_layanan}/{no_antrian}', 'AntrianFrontOfficeController@update');
Route::delete('antrian_front_office/{nama_layanan}/{no_antrian}', 'AntrianFrontOfficeController@destroy');

Route::resource('antrian', 'AntrianController', ['except' => [
  'edit', 'show', 'create', 'update', 'delete'
]]);
Route::get('antrian/{nama_layanan}', 'AntrianController@show');
Route::put('antrian/{nama_layanan}/{no_antrian}', 'AntrianController@update');
Route::delete('antrian/{nama_layanan}/{no_antrian}', 'AntrianController@destroy');

Route::post('bpjs', 'BpjsController@process');
Route::get('transaksi/latest/{id_pasien}', 'TransaksiController@getLatestOpenTransaksi');
Route::get('transaksi/search_by_pasien', 'TransaksiController@searchByPasien');
Route::get('transaksi/{id}/bpjs', 'TransaksiController@getStatusBpjs');
Route::resource('transaksi', 'TransaksiController');
Route::get('transaksi/search/{nama_pasien}', 'TransaksiController@getRecentTransaksi');

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
  'edit', 'create'
]]);
Route::get('diagnosis/{id_pasien}/{tanggal_waktu}', 'DiagnosisController@getDiagnosisOfRekamMedis');

Route::resource('daftar_tindakan', 'DaftarTindakanController', ['except' => [
  'edit', 'create'
]]);

Route::resource('tindakan', 'TindakanController', ['except' => [
  'edit', 'create', 'show', 'update', 'destroy'
]]);

Route::resource('tindakan_operasi', 'TindakanOperasiController', ['except' => [
  'edit', 'create', 'show', 'update', 'destroy'
]]);

Route::get('tindakan_operasi/{pemakaianKamarOperasiId}', 'TindakanOperasiController@show');
Route::post('tindakan_operasi/{id_tindakan}', 'TindakanOperasiController@store');

Route::get('tindakan/{no_transaksi}/{no_tindakan?}', 'TindakanController@show');
Route::get('tindakan/rekam_medis/{id_pasien}/{tanggal_waktu}', 'TindakanController@getTindakanOfRekamMedis');
Route::put('tindakan/{no_transaksi}/{no_tindakan}', 'TindakanController@update');
Route::delete('tindakan/{no_transaksi}/{no_tindakan?}', 'TindakanController@destroy');

Route::resource('poliklinik', 'PoliklinikController', ['except' => [
  'edit', 'create'
]]);

Route::resource('laboratorium', 'LaboratoriumController', ['except' => [
  'edit', 'create'
]]);

Route::resource('hasil_lab', 'HasilLabController', ['except' => [
  'edit', 'create', 'get_empty'
]]);

Route::get('hasil_lab/empty/{no_pegawai}', 'HasilLabController@get_empty');

Route::resource('ambulans', 'AmbulansController', ['except' => [
  'edit', 'create'
]]);

Route::resource('tenaga_medis', 'TenagaMedisController', ['except' => [
  'edit', 'create'
]]);

Route::resource('dokter', 'DokterController', ['except' => [
  'edit', 'create'
]]);

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

Route::post('pemakaiankamarrawatinap/booking/{tanggal}', 'PemakaianKamarRawatInapController@storeBooked');

Route::put('pemakaiankamarrawatinap/{id}/{no_kamar}/{no_tempat_tidur}', 'PemakaianKamarRawatinapController@update');
Route::delete('pemakaiankamarrawatinap/{id}/{no_kamar}/{no_tempat_tidur}', 'PemakaianKamarRawatinapController@destroy');
Route::delete('pemakaiankamarrawatinap/booking/{id}', 'PemakaianKamarRawatinapController@destroyBooking');
Route::put('pemakaiankamarrawatinap/pindah/{id}', 'PemakaianKamarRawatinapController@pindahKamar');
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

Route::get('rawatinap/{no_kamar}', 'KamarRawatInapController@show');
Route::put('rawatinap/{no_kamar}', 'KamarRawatInapController@update');
Route::post('rawatinap/{no_kamar}', 'PemakaianKamarRawatInapController@store');
Route::put('rawatinap/booking/{id}', 'PemakaianKamarRawatInapController@masuk');

Route::put('tempattidur/{no_kamar}/{no_tempat_tidur}', 'TempatTidurController@update');

// Route::get('resep/search_by_transaksi', 'ResepController@searchByTransaksi');
Route::get('resep/search_by_pasien', 'ResepController@searchByPasien');
// Route::get('resep/search_by_pasien_and_tanggal', 'ResepController@searchByPasienAndTanggal');
Route::resource('resep', 'ResepController');
Route::resource('resep_item', 'ResepItemController');
Route::resource('racikan_item', 'RacikanItemController');

Route::get('jenis_obat/search', 'JenisObatController@search');
Route::resource('jenis_obat', 'JenisObatController');
Route::resource('lokasi_obat', 'LokasiObatController');
Route::get('obat_masuk/search', 'ObatMasukController@search');
Route::resource('obat_masuk', 'ObatMasukController');
Route::get('stok_obat/search_by_jenis_obat_and_batch', 'StokObatController@searchByJenisObatAndBatch');
Route::get('stok_obat/search_by_location', 'StokObatController@searchByLocation');
Route::resource('stok_obat', 'StokObatController');
Route::resource('obat_pindah', 'ObatPindahController');
Route::resource('obat_rusak', 'ObatRusakController');
Route::resource('obat_tebus', 'ObatTebusController');
Route::resource('obat_tindakan', 'ObatTindakanController');
Route::resource('obat_eceran', 'ObatEceranController');
Route::get('stock_opname/search_by_location', 'StockOpnameController@searchByLocation');
Route::resource('stock_opname', 'StockOpnameController');
