<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StokObat;

class StokObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return StokObat::with('obatMasuk','jenisObat','lokasiData')->get();
    }

    // TO-DO: Remove as updates will be done by other controllers
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stok_obat = new StokObat;
        $stok_obat->id_jenis_obat = $request->input('id_jenis_obat');
        $stok_obat->id_obat_masuk = $request->input('id_obat_masuk');
        $stok_obat->jumlah = $request->input('jumlah');       
        $stok_obat->lokasi = $request->input('lokasi');
        $stok_obat->save();
        return response ($stok_obat, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return StokObat::with('obatMasuk','jenisObat','lokasiData')->findOrFail($id);
    }

    // TO-DO: Remove as updates will be done by other controllers
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $stok_obat = StokObat::findOrFail($id);
        $stok_obat->id_jenis_obat = $request->input('id_jenis_obat');
        $stok_obat->id_obat_masuk = $request->input('id_obat_masuk');
        $stok_obat->jumlah = $request->input('jumlah');       
        $stok_obat->lokasi = $request->input('lokasi');
        $stok_obat->save();
        return response ($stok_obat, 200)
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
        $stok_obat = StokObat::find($id);
        $stok_obat->delete();
        return response ($id.' deleted', 200);
    }

    public function searchByJenisObatAndBatch(Request $request)
    {
        $stok_obat = StokObat::join('obat_masuk','obat_masuk.id', '=', 'stok_obat.id_obat_masuk')
                                ->where('stok_obat.id_jenis_obat', $request->input('id_jenis_obat'))
                                ->where('obat_masuk.nomor_batch', 'LIKE', $request->input('nomor_batch'))
                                ->where('lokasi', $request->input('lokasi'))
                                ->select('stok_obat.*')
                                ->firstOrFail();
        return response ($stok_obat, 200)
                -> header('Content-Type', 'application/json');
    }

    public function searchByLocation(Request $request)
    {
        $stok_obat = StokObat::with('obatMasuk', 'jenisObat')
                                ->where('lokasi', $request->input('lokasi'))
                                ->get();
        return response ($stok_obat, 200)
                -> header('Content-Type', 'application/json');
    }
}
