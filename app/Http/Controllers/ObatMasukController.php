<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ObatMasuk;
use App\StokObat;

class ObatMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ObatMasuk::with('jenisObat')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TO-DO: Make into transaction?
        // TO-DO: Should an entry be made in ObatPindah also?
        $obat_masuk = new ObatMasuk;
        $obat_masuk->id_jenis_obat = $request->input('id_jenis_obat');
        $obat_masuk->nomor_batch = $request->input('nomor_batch');
        $obat_masuk->waktu_masuk = $request->input('waktu_masuk');
        $obat_masuk->jumlah = $request->input('jumlah');
        $obat_masuk->harga_beli_satuan = $request->input('harga_beli_satuan');
        $obat_masuk->kadaluarsa = $request->input('kadaluarsa');

        $stok_obat = new StokObat;
        $stok_obat->id_jenis_obat = $request->input('id_jenis_obat');
        $stok_obat->jumlah = $request->input('jumlah');       
        $stok_obat->lokasi = 1;

        $obat_masuk->save();
        $stok_obat->id_obat_masuk = $obat_masuk->id;
        $stok_obat->save();

        return response ($obat_masuk, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ObatMasuk::with('jenisObat')->findOrFail($id);
    }

    // TO-DO: Remove or restrict updates
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $obat_masuk = ObatMasuk::findOrFail($id);
        $obat_masuk->id_jenis_obat = $request->input('id_jenis_obat');
        $obat_masuk->nomor_batch = $request->input('nomor_batch');
        $obat_masuk->waktu_masuk = $request->input('waktu_masuk');
        $obat_masuk->jumlah = $request->input('jumlah');
        $obat_masuk->harga_beli_satuan = $request->input('harga_beli_satuan');
        $obat_masuk->kadaluarsa = $request->input('kadaluarsa');
        $obat_masuk->save();
        return response ($obat_masuk, 200)
            -> header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $obat_masuk = ObatMasuk::find($id);
        $obat_masuk->delete();
        return response ($id.' deleted', 200);
    }
}
