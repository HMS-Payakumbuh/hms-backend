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

Route::post('bpjs', 'BpjsController@process');
Route::resource('transaksi', 'TransaksiController');
Route::resource('klaim', 'KlaimController');
Route::resource('pembayaran', 'PembayaranController');
Route::resource('asuransi', 'AsuransiController');

Route::resource('setting_bpjs', 'SettingBpjsController', ['except' => [
  'edit', 'create'
]]);

Route::resource('jaminan', 'JaminanController', ['except' => [
  'edit', 'create'
]]);

Route::resource('cob', 'CobController', ['except' => [
  'edit', 'create'
]]);

Route::resource('daftar_tindakan', 'DaftarTindakanController', ['except' => [
  'edit', 'create'
]]);

Route::resource('tindakan', 'TindakanController', ['except' => [
  'edit', 'create', 'show', 'update', 'destroy'
]]);

Route::get('tindakan/{no_transaksi}/{no_tindakan?}', 'TindakanController@show');
Route::put('tindakan/{no_transaksi}/{no_tindakan}', 'TindakanController@update');
Route::delete('tindakan/{no_transaksi}/{no_tindakan?}', 'TindakanController@destroy');

Route::resource('daftar_diagnosis', 'DaftarDiagnosisController', ['except' => [
  'edit', 'create'
]]);

Route::resource('poliklinik', 'PoliklinikController', ['except' => [
  'edit', 'create'
]]);

Route::resource('laboratorium', 'LaboratoriumController', ['except' => [
  'edit', 'create'
]]);

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
Route::put('jadwal_dokter/{nama_poli}/{np_dokter}/{tanggal}', 'JadwalDokterController@update');
Route::delete('jadwal_dokter/{nama_poli}/{np_dokter}/{tanggal}', 'JadwalDokterController@destroy');

Route::resource('jadwal_dokter', 'JadwalDokterController', ['except' => [
  'edit', 'create', 'show', 'update', 'destroy'
]]);

Route::resource('rawatinap', 'KamarRawatInapController', ['except' => [
  'edit', 'create'
]]);

Route::resource('kamaroperasi', 'PemakaianKamarOperasiController', ['except' => [
  'edit', 'create'
]]);

Route::get('rawatinap/{no_kamar}', 'KamarRawatInapController@show');
Route::get('rawatinap/{no_kamar}', 'PemakaianKamarRawatInapController@search');



Route::get('jenis_obat/search', 'JenisObatController@search');
Route::resource('jenis_obat', 'JenisObatController');
Route::resource('lokasi_obat', 'LokasiObatController');
Route::get('obat_masuk/search', 'ObatMasukController@search');
Route::resource('obat_masuk', 'ObatMasukController');
Route::get('stok_obat/search', 'StokObatController@search');
Route::resource('stok_obat', 'StokObatController');
Route::resource('obat_pindah', 'ObatPindahController');
Route::resource('obat_rusak', 'ObatRusakController');
Route::resource('obat_tebus', 'ObatTebusController');
Route::resource('obat_tindakan', 'ObatTindakanController');
