<?php

namespace App\Http\Controllers;

use App\DaftarTindakan;
use Illuminate\Http\Request;

class DaftarTindakanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DaftarTindakan::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $daftarTindakan = new DaftarTindakan;
        $daftarTindakan->kode = $request->input('kode');
        $daftarTindakan->nama = $request->input('nama');
        $daftarTindakan->harga = $request->input('harga');
        $daftarTindakan->save();

        return response($daftarTindakan, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $kode
     * @return \Illuminate\Http\Response
     */
    public function show($kode)
    {
        return DaftarTindakan::findOrFail($kode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $kode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kode)
    {
        $daftarTindakan = DaftarTindakan::findOrFail($kode);
        $daftarTindakan->kode = $request->input('kode');
        $daftarTindakan->nama = $request->input('nama');
        $daftarTindakan->harga = $request->input('harga');
        $daftarTindakan->save();

        return response($daftarTindakan, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $kode
     * @return \Illuminate\Http\Response
     */
    public function destroy($kode)
    {
        DaftarTindakan::destroy($kode);
        return response('', 204);
    }
}
