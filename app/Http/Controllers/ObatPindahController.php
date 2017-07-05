<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ObatPindah;
use App\StokObat;

class ObatPindahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ObatPindah::with('obatMasuk','jenisObat','lokasiAsal','lokasiTujuan')->get();
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
        $obat_pindah = new ObatPindah;
        $obat_pindah->id_jenis_obat = $request->input('id_jenis_obat');
        $obat_pindah->id_obat_masuk = $request->input('id_obat_masuk');

        date_default_timezone_set('Asia/Jakarta');
        $obat_pindah->waktu_pindah = date("Y-m-d H:i:s"); // Use default in DB instead?
        
        $obat_pindah->jumlah = $request->input('jumlah');
        $obat_pindah->keterangan = $request->input('keterangan');
        $obat_pindah->asal = $request->input('asal');
        $obat_pindah->tujuan = $request->input('tujuan');
        $obat_pindah->save();

        $stok_obat_asal = StokObat::where('id_obat_masuk', $obat_pindah->id_obat_masuk)
                                    ->where('lokasi', $obat_pindah->asal)
                                    ->first(); //TO-DO: Error handling - firstOrFail?
        $stok_obat_asal->jumlah = ($stok_obat_asal->jumlah) - ($obat_pindah->jumlah);

        $stok_obat_tujuan = StokObat::where('id_obat_masuk', $obat_pindah->id_obat_masuk)
                                    ->where('lokasi', $obat_pindah->tujuan)
                                    ->first(); //TO-DO: Error handling - firstOrFail?
        if (!$stok_obat_tujuan) {
            $stok_obat_tujuan = new StokObat;
        } 

        $stok_obat_tujuan->id_jenis_obat = $obat_pindah->id_jenis_obat; 
        $stok_obat_tujuan->id_obat_masuk = $obat_pindah->id_obat_masuk;
        $stok_obat_tujuan->jumlah =  ($stok_obat_tujuan->jumlah) + ($obat_pindah->jumlah);       
        $stok_obat_tujuan->lokasi = $obat_pindah->tujuan;

        $stok_obat_asal->save();
        $stok_obat_tujuan->save();

        return response ($obat_pindah, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ObatPindah::with('obatMasuk','jenisObat','lokasiAsal','lokasiTujuan')->findOrFail($id);
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
        $obat_pindah = ObatPindah::findOrFail($id);
        $obat_pindah->id_jenis_obat = $request->input('id_jenis_obat');
        $obat_pindah->id_obat_masuk = $request->input('id_obat_masuk');
        $obat_pindah->waktu_pindah = $request->input('waktu_pindah');
        $obat_pindah->jumlah = $request->input('jumlah');
        $obat_pindah->keterangan = $request->input('keterangan');
        $obat_pindah->asal = $request->input('asal');
        $obat_pindah->tujuan = $request->input('tujuan');
        $obat_pindah->save();
        return response ($obat_pindah, 200)
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
        $obat_pindah = ObatPindah::find($id);
        $obat_pindah->delete();
        return response ($id.' deleted', 200);
    }
}
