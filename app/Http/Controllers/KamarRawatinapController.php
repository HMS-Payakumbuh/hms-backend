<?php

namespace App\Http\Controllers;

use App\KamarRawatinap;
use Illuminate\Http\Request;

class KamarRawatinap extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return KamarRawatinap::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kamarRawatinap = new KamarRawatinap;
        $kamarRawatinap->no_kamar = $request->input('no_kamar');
        $kamarRawatinap->jenis_kamar = $request->input('jenis_kamar');
        $kamarRawatinap->kelas = $request->input('kelas');
        $kamarRawatinap->harga_per_hari = $request->input('harga_per_hari');
        $kamarRawatinap->save();

        return response($kamarRawatinap, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function show($no_kamar)
    {
        return KamarRawatinap::findOrFail($no_kamar);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $no_kamar)
    {
        $kamarRawatinap = KamarRawatinap::findOrFail($no_kamar);
        $kamarRawatinap->no_kamar = $request->input('no_kamar');
        $kamarRawatinap->jenis_kamar = $request->input('jenis_kamar');
        $kamarRawatinap->kelas = $request->input('kelas');
        $kamarRawatinap->harga_per_hari = $request->input('harga_per_hari');
        $kamarRawatinap->save();

        return response($kamarRawatinap, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function destroy($no_kamar)
    {
        KamarRawatinap::destroy($no_kamar);
        return response('', 204);
    }
}
