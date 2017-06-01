<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('ID/{id}',function($id){
	echo 'ID: '.$id;
});
Route::resource('pasien', 'PasienController');
Route::get('/pasien/create', function () {
	return view('pasien/create');
});
Route::post('/pasien/create', array('uses'=>'PasienController@store'));