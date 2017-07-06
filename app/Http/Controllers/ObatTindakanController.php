<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ObatTindakan;
use App\StokObat;

class ObatTindakanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ObatTindakan::with('obatMasuk','jenisObat','lokasiAsal')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            $obat_tindakan = new ObatTindakan;

            $obat_tindakan->id_jenis_obat = $value['id_jenis_obat'];
            $obat_tindakan->id_obat_masuk = $value['id_obat_masuk'];

            date_default_timezone_set('Asia/Jakarta');
            $obat_tindakan->waktu_keluar = date("Y-m-d H:i:s"); // Use default in DB instead?
            
            $obat_tindakan->jumlah = $value['jumlah'];       
            $obat_tindakan->keterangan = $value['keterangan'];
            $obat_tindakan->asal = $value['asal'];
            $obat_tindakan->harga_jual_realisasi = $value['harga_jual_realisasi'];    
            $obat_tindakan->id_transaksi = $value['id_transaksi'];
            $obat_tindakan->id_tindakan = $value['id_tindakan'];       

            $obat_tindakan->save();

            $stok_obat_asal = StokObat::where('id_obat_masuk', $obat_tindakan->id_obat_masuk)
                                    ->where('lokasi', $obat_tindakan->asal)
                                    ->first(); //TO-DO: Error handling - firstOrFail?
            $stok_obat_asal->jumlah = ($stok_obat_asal->jumlah) - ($obat_tindakan->jumlah);
            $stok_obat_asal->save();
        }
        return response ($request->all(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ObatTindakan::with('obatMasuk','jenisObat','lokasiAsal')->findOrFail($id);
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
        // TO-DO: Make into transaction?
        // TO-DO: Restriction checking (jumlah > 0 etc.)
        $obat_tindakan = ObatTindakan::findOrFail($id);

        $obat_tindakan->id_jenis_obat = $value['id_jenis_obat'];
        $obat_tindakan->id_obat_masuk = $value['id_obat_masuk'];        
        $obat_tindakan->jumlah = $value['jumlah'];       
        $obat_tindakan->keterangan = $value['keterangan'];
        $obat_tindakan->asal = $value['asal'];
        $obat_tindakan->harga_jual_realisasi = $value['harga_jual_realisasi'];    
        $obat_tindakan->id_transaksi = $value['id_transaksi'];
        $obat_tindakan->id_tindakan = $value['id_tindakan'];     
        $obat_tindakan->save();

        $stok_obat_asal = StokObat::where('id_obat_masuk', $obat_tindakan->id_obat_masuk)
                                    ->where('lokasi', $obat_tindakan->asal)
                                    ->first(); //TO-DO: Error handling - firstOrFail?
        $stok_obat_asal->jumlah = ($stok_obat_asal->jumlah) - ($obat_tindakan->jumlah);
        $stok_obat_asal->save();
        
        return response ($obat_tindakan, 200)
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
        $obat_tindakan = ObatTindakan::find($id);
        $obat_tindakan->delete();
        return response ($id.' deleted', 200);
    }
}
