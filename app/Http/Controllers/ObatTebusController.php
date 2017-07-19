<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\ObatTebus;
use App\StokObat;
use App\ObatTebusItem;

class ObatTebusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ObatTebus::with('obatTebusItem','resep','transaksi.pasien','obatTebusItem.obatMasuk','obatTebusItem.jenisObat')->get();
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
        $obat_tebus->id_transaksi = $request->input('id_transaksi');    
        $obat_tebus->id_resep = $request->input('id_resep');
        date_default_timezone_set('Asia/Jakarta');
        $obat_tebus->waktu_keluar = date("Y-m-d H:i:s"); // Use default in DB instead?
        $obat_tebus->save();

        foreach ($request->input('obat_tebus_item') as $key => $value) {
            $obat_tebus_item = new ObatTebusItem;

            $obat_tebus_item->id_obat_tebus = $obat_tebus->id;
            $obat_tebus_item->id_jenis_obat = $value['id_jenis_obat'];
            $obat_tebus_item->id_obat_masuk = $value['id_obat_masuk'];
            $obat_tebus_item->jumlah = $value['jumlah'];
            $obat_tebus_item->harga_jual_realisasi = $value['harga_jual_realisasi'];
            $obat_tebus_item->keterangan = $value['keterangan'];
            $obat_tebus_item->asal = $value['asal'];
            $obat_tebus_item->id_resep_item = $value['id_resep_item'];
            $obat_tebus_item->id_racikan_item = $value['id_racikan_item'];            

            $stok_obat_asal = StokObat::where('id_obat_masuk', $obat_tebus_item->id_obat_masuk)
                                        ->where('lokasi', $obat_tebus_item->asal)
                                        ->first(); //TO-DO: Error handling - firstOrFail?
            $stok_obat_asal->jumlah = ($stok_obat_asal->jumlah) - ($obat_tebus_item->jumlah);

            if ($obat_tebus_item->save()) {
                $transaksi = Transaksi::findOrFail($obat_tebus->id_transaksi);
                $transaksi->harga_total += $obat_tebus_item->harga_jual_realisasi * $obat_tebus_item->jumlah;
                $transaksi->save();
            }
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
        return ObatTebus::with('obatTebusItem','resep','transaksi.pasien', 'obatTebusItem.obatMasuk','obatTebusItem.jenisObat')->findOrFail($id);
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
        $obat_tebus->id_transaksi = $request->input('id_transaksi');   
        $obat_tebus->id_resep = $request->input('id_resep');
        date_default_timezone_set('Asia/Jakarta');
        $obat_tebus->waktu_keluar = date("Y-m-d H:i:s"); // Use default in DB instead?
        $obat_tebus->save();

        foreach ($request->input('obat_tebus_item') as $key => $value) {
            $obat_tebus_item = new ObatTebusItem;

            $obat_tebus_item->id_obat_tebus = $obat_tebus->id;
            $obat_tebus_item->id_jenis_obat = $value['id_jenis_obat'];
            $obat_tebus_item->id_obat_masuk = $value['id_obat_masuk'];
            $obat_tebus_item->jumlah = $value['jumlah'];
            $obat_tebus_item->harga_jual_realisasi = $value['harga_jual_realisasi'];
            $obat_tebus_item->keterangan = $value['keterangan'];
            $obat_tebus_item->asal = $value['asal'];
            $obat_tebus_item->id_resep_item = $value['id_resep_item'];
            $obat_tebus_item->id_racikan_item = $value['id_racikan_item'];            

            $stok_obat_asal = StokObat::where('id_obat_masuk', $obat_tebus_item->id_obat_masuk)
                                        ->where('lokasi', $obat_tebus_item->asal)
                                        ->first(); //TO-DO: Error handling - firstOrFail?
            $stok_obat_asal->jumlah = ($stok_obat_asal->jumlah) - ($obat_tebus_item->jumlah);

            $obat_tebus_item->save();
            $stok_obat_asal->save();
        }           

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
