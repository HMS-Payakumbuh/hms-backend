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

Route::resource('transaksi', 'TransaksiController');
Route::resource('klaim', 'TransaksiController');
Route::resource('pembayaran', 'TransaksiController');
Route::resource('asuransi', 'TransaksiController');

Route::resource('daftar_tindakan', 'DaftarTindakanController', ['except' => [
  'edit', 'create'
]]);

Route::resource('daftar_diagnosis', 'DaftarDiagnosisController', ['except' => [
  'edit', 'create'
]]);

Route::resource('poliklinik', 'PoliklinikController', ['except' => [
  'edit', 'create'
]]);

Route::get('jenis_obat/search', 'JenisObatController@search')->middleware('cors');

Route::group(['middleware' => 'cors'], function() {
  Route::resource('jenis_obat', 'JenisObatController');
});

Route::resource('lokasi_obat', 'LokasiObatController');
Route::get('jenis_obat/search', 'JenisObatController@search');
Route::resource('jenis_obat', 'JenisObatController');
Route::resource('lokasi_obat', 'LokasiObatController');
Route::resource('obat_masuk', 'ObatMasukController');
Route::resource('stok_obat', 'StokObatController');
Route::resource('obat_pindah', 'ObatPindahController');
Route::resource('obat_rusak', 'ObatRusakController');
Route::resource('obat_tebus', 'ObatTebusController');
Route::resource('obat_tindakan', 'ObatTindakanController');
