<?php

namespace App\Http\Controllers;

use App\PemakaianKamarRawatinap;
use App\TempatTidur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemakaianKamarRawatinapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemakaianKamarRawatinap = PemakaianKamarRawatinap
                            ::join('transaksi', 'pemakaian_kamar_rawatinap.id_transaksi', '=', 'transaksi.id')
                            ->join('pasien', 'transaksi.id_pasien', '=', 'pasien.id')
                            ->join('tenaga_medis', 'pemakaian_kamar_rawatinap.no_pegawai', '=', 'tenaga_medis.no_pegawai')
                            ->select(DB::raw('pemakaian_kamar_rawatinap.id,pemakaian_kamar_rawatinap.no_kamar, pemakaian_kamar_rawatinap.no_tempat_tidur, pasien.nama_pasien, tenaga_medis.nama, pemakaian_kamar_rawatinap.waktu_masuk, pemakaian_kamar_rawatinap.waktu_keluar, pemakaian_kamar_rawatinap.id_transaksi'))
                            ->get();          

        return $pemakaianKamarRawatinap;
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
        $pemakaianKamarRawatinap->id_transaksi = $request->input('id_transaksi');
        date_default_timezone_set('Asia/Jakarta');
        $pemakaianKamarRawatinap->waktu_masuk = date("Y-m-d H:i:s");
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
    public function update(Request $request, $id, $no_kamar, $no_tempat_tidur)
    {
        $pemakaianKamarRawatinap = PemakaianKamarRawatinap::findOrFail($id);

        // $pemakaianKamarRawatinap->no_kamar = $request->input('no_kamar');
        // $pemakaianKamarRawatinap->no_tempat_tidur = $request->input('no_tempat_tidur');
        // $pemakaianKamarRawatinap->no_transaksi = $request->input('no_transaksi');
        // $pemakaianKamarRawatinap->no_pembayaran = $request->input('no_pembayaran');
        // $pemakaianKamarRawatinap->waktu_masuk = $request->input('waktu_masuk');
        date_default_timezone_set('Asia/Jakarta');
        $pemakaianKamarRawatinap->waktu_keluar = date("Y-m-d H:i:s");
        // $pemakaianKamarRawatinap->harga = $request->input('harga');
        // $pemakaianKamarRawatinap->no_pegawai= $request->input('no_pegawai');
        // $pemakaianKamarRawatinap->status = $request->input('status');
        $pemakaianKamarRawatinap->save();

        $tempatTidur = TempatTidur::where('no_kamar', '=', $no_kamar)
        ->where('no_tempat_tidur', '=', $no_tempat_tidur)
        ->first();

        $tempatTidur->status = 1;
        $tempatTidur->save();


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
    public function destroy($id, $no_kamar, $no_tempat_tidur)
    {
        $pemakaianKamarRawatinap = PemakaianKamarRawatinap::findOrFail($id);
        $pemakaianKamarRawatinap->delete();

        $tempatTidur = TempatTidur::where('no_kamar', '=', $no_kamar)
        ->where('no_tempat_tidur', '=', $no_tempat_tidur)
        ->first();

        $tempatTidur->status = 1;
        $tempatTidur->save();

        return response('', 204);

    }
}
