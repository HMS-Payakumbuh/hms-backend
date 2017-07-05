<?php

namespace App\Http\Controllers;

use App\PemakaianKamarRawatinap;
use Illuminate\Http\Request;

class PemakaianKamarRawatinapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PemakaianKamarRawatinap::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pemakaianKamarRawatinap = new PemakaianKamarRawatinap;
        $pemakaianKamarRawatinap->no_kamar = $request->input('no_kamar');
        $pemakaianKamarRawatinap->no_tempat_tidur = $request->input('no_tempat_tidur');
        $pemakaianKamarRawatinap->no_transaksi = $request->input('no_transaksi');
        $pemakaianKamarRawatinap->no_pembayaran = $request->input('no_pembayaran');
        $pemakaianKamarRawatinap->waktu_masuk = $request->input('waktu_masuk');
        $pemakaianKamarRawatinap->waktu_keluar = null;
        $pemakaianKamarRawatinap->harga = $request->input('harga');
        $pemakaianKamarRawatinap->no_pegawai= $request->input('no_pegawai');
        $pemakaianKamarRawatinap->save();

        return response($pemakaianKamarRawatinap, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function show($no_kamar)
    {
        return PemakaianKamarRawatinap::findOrFail($no_kamar);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $no_kamar
     * @param  integer $no_tempat_tidur
     * @param  integer  $no_transaksi
     * @param  datetime  $waktu_masuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $no_kamar, $no_tempat_tidur, $no_transaksi, $waktu_masuk)
    {
        $pemakaianKamarRawatinap = PemakaianKamarRawatinap ::where('no_kamar', '=', $no_kamar)
        ->where('no_tempat_tidur', '=', $no_tempat_tidur)
        ->where('no_transaksi', '=', $no_transaksi)
        ->where('waktu_masuk', '=', $waktu_masuk)
        ->first();

        $pemakaianKamarRawatinap->no_kamar = $request->input('no_kamar');
        $pemakaianKamarRawatinap->no_tempat_tidur = $request->input('no_tempat_tidur');
        $pemakaianKamarRawatinap->no_transaksi = $request->input('no_transaksi');
        $pemakaianKamarRawatinap->no_pembayaran = $request->input('no_pembayaran');
        $pemakaianKamarRawatinap->waktu_masuk = $request->input('waktu_masuk');
        $pemakaianKamarRawatinap->waktu_keluar = $request->input('waktu_keluar');
        $pemakaianKamarRawatinap->harga = $request->input('harga');
        $pemakaianKamarRawatinap->no_pegawai= $request->input('no_pegawai');
        $pemakaianKamarRawatinap->status = $request->input('status');
        $pemakaianKamarRawatinap->save();

        return response($pemakaianKamarRawatinap, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $no_kamar
     * @param  integer $no_tempat_tidur
     * @param  integer  $no_transaksi
     * @param  datetime  $waktu_masuk
     * @return \Illuminate\Http\Response
     */
    public function destroy($no_kamar, $no_tempat_tidur, $no_transaksi, $waktu_masuk)
    {
         $deletedRows = PemakaianKamarRawatinap ::where('no_kamar', '=', $no_kamar)
        ->where('no_tempat_tidur', '=', $no_tempat_tidur)
        ->where('no_transaksi', '=', $no_transaksi)
        ->where('waktu_masuk', '=', $waktu_masuk)
        ->first()
        ->delete();

        return response('', 204);

    }
}
