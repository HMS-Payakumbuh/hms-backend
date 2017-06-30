<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ObatTebus;
use App\StokObat;

class ObatTebusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ObatTebus::with('obatMasuk','jenisObat','lokasiAsal')->get();
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
        // TO-DO: Restriction checking (jumlah > 0 etc.)
        $obat_tebus = new ObatTebus;
        $obat_tebus->id_jenis_obat = $request->input('id_jenis_obat');
        $obat_tebus->id_obat_masuk = $request->input('id_obat_masuk');
        $obat_tebus->waktu_keluar = $request->input('waktu_keluar');
        $obat_tebus->jumlah = $request->input('jumlah');       
        $obat_tebus->keterangan = $request->input('keterangan');
        $obat_tebus->asal = $request->input('asal');
        $obat_tebus->id_transaksi = $request->input('id_transaksi');
        $obat_tebus->id_tindakan = $request->input('id_tindakan');        
        $obat_tebus->id_resep = $request->input('id_resep');
        $obat_tebus->id_resep_item = $request->input('id_resep_item');
        $obat_tebus->save();

        $stok_obat_asal = StokObat::where('id_obat_masuk', $obat_tebus->id_obat_masuk)
                                    ->where('lokasi', $obat_tebus->asal)
                                    ->first(); //TO-DO: Error handling - firstOrFail?
        $stok_obat_asal->jumlah = ($stok_obat_asal->jumlah) - ($obat_tebus->jumlah);
        $stok_obat_asal->save();

        return response ($obat_tebus, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ObatTebus::with('obatMasuk','jenisObat','lokasiAsal')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $obat_tebus = ObatTebus::findOrFail($id);
        $obat_tebus->id_jenis_obat = $request->input('id_jenis_obat');
        $obat_tebus->id_obat_masuk = $request->input('id_obat_masuk');
        $obat_tebus->waktu_keluar = $request->input('waktu_keluar');
        $obat_tebus->jumlah = $request->input('jumlah');       
        $obat_tebus->keterangan = $request->input('keterangan');
        $obat_tebus->asal = $request->input('asal');
        $obat_tebus->id_transaksi = $request->input('id_transaksi');
        $obat_tebus->id_tindakan = $request->input('id_tindakan');        
        $obat_tebus->id_resep = $request->input('id_resep');
        $obat_tebus->id_resep_item = $request->input('id_resep_item');
        $obat_tebus->save();
        return response ($obat_tebus, 200)
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
        $obat_tebus = ObatTebus::find($id);
        $obat_tebus->delete();
        return response ($id.' deleted', 200);
    }
}
