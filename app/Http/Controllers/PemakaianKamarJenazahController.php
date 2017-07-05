<?php

namespace App\Http\Controllers;

use App\PemakaianKamarJenazah;
use Illuminate\Http\Request;

class PemakaianKamarJenazah extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PemakaianKamarJenazah::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pemakaianKamarJenazah = new PemakaianKamarJenazah;
        $pemakaianKamarJenazah->no_kamar = $request->input('no_kamar');
        $pemakaianKamarJenazah->no_transaksi = $request->input('no_transaksi');
        $pemakaianKamarJenazah->no_pembayaran = $request->input('no_pembayaran');
        $pemakaianKamarJenazah->waktu_masuk = $request->input('waktu_masuk');
        $pemakaianKamarJenazah->waktu_keluar = null;
        $pemakaianKamarJenazah->harga = $request->input('harga');
        $pemakaianKamarJenazah->save();

        return response($pemakaianKamarJenazah, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function show($no_kamar)
    {
        return PemakaianKamarJenazah::findOrFail($no_kamar);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $no_kamar
     * @param  integer  $no_transaksi
     * @param  datetime  $waktu_masuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $no_kamar, $no_transaksi, $waktu_masuk)
    {
        $pemakaianKamarJenazah = PemakaianKamarJenazah ::where('no_kamar', '=', $no_kamar)
        ->where('no_transaksi', '=', $no_transaksi)
        ->where('waktu_masuk', '=', $waktu_masuk)
        ->first();

        $pemakaianKamarJenazah->no_kamar = $request->input('no_kamar');
        $pemakaianKamarJenazah->no_transaksi = $request->input('no_transaksi');
        $pemakaianKamarJenazah->no_pembayaran = $request->input('no_pembayaran');
        $pemakaianKamarJenazah->waktu_masuk = $request->input('waktu_masuk');
        $pemakaianKamarJenazah->waktu_keluar = $request->input('waktu_keluar');
        $pemakaianKamarJenazah->harga = $request->input('harga');
        $pemakaianKamarJenazah->save();

        return response($pemakaianKamarJenazah, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $no_kamar
     * @param  integer  $no_transaksi
     * @param  datetime  $waktu_masuk
     * @return \Illuminate\Http\Response
     */
    public function destroy($no_kamar, $no_transaksi, $waktu_masuk)
    {
         $deletedRows = PemakaianKamarJenazah ::where('no_kamar', '=', $no_kamar)
        ->where('no_transaksi', '=', $no_transaksi)
        ->where('waktu_masuk', '=', $waktu_masuk)
        ->first()
        ->delete();

        return response('', 204);

    }
}
