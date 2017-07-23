<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ObatEceran;
use App\StokObat;
use App\ObatEceranItem;
use App\Transaksi;

class ObatEceranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return ObatEceran::with('obatEceranItem.obatMasuk','obatEceranItem.jenisObat')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $obat_eceran = new ObatEceran;
        $obat_eceran->nama_pembeli = $request->input('nama_pembeli');
        $obat_eceran->alamat = $request->input('alamat');

        date_default_timezone_set('Asia/Jakarta');
        $obat_eceran->waktu_transaksi = date("Y-m-d H:i:s"); // Use default in DB instead?

        if ($request->input('id_transaksi')) {
            $obat_eceran->id_transaksi = $request->input('id_transaksi');               
        } else {
            $transaksi = new Transaksi;        
            $transaksi->kode_jenis_pasien = 1;
            $transaksi->asuransi_pasien = 'tunai';        
            $transaksi->harga_total = 0;
            $transaksi->jenis_rawat = 2;
            $transaksi->kelas_rawat = 3;
            $transaksi->status_naik_kelas = 0;
            $transaksi->status = 'open';
            $transaksi->save();

            $transaksi = Transaksi::findOrFail($transaksi->id);
            $code_str = strtoupper(base_convert($transaksi->id, 10, 36));
            $code_str = str_pad($code_str, 8, '0', STR_PAD_LEFT);
            $transaksi->no_transaksi = 'INV' . $code_str;
            $transaksi->save();

            $obat_eceran->id_transaksi = $transaksi->id;  
        }

        $obat_eceran->save();

        foreach ($request->input('obat_eceran_item') as $key => $value) {
            $obat_eceran_item = new ObatEceranItem;

            $obat_eceran_item->id_obat_eceran = $obat_eceran->id;
            $obat_eceran_item->id_jenis_obat = $value['id_jenis_obat'];
            $obat_eceran_item->id_obat_masuk = $value['id_obat_masuk'];
            $obat_eceran_item->jumlah = $value['jumlah'];
            $obat_eceran_item->harga_jual_realisasi = $value['harga_jual_realisasi'];
            $obat_eceran_item->keterangan = $value['keterangan'];

            $stok_obat_asal = StokObat::where('id_obat_masuk', $obat_eceran_item->id_obat_masuk)
                                        ->where('lokasi', 2)
                                        ->firstOrFail(); //TO-DO: Error handling - firstOrFail?
            $stok_obat_asal->jumlah = ($stok_obat_asal->jumlah) - ($obat_eceran_item->jumlah);    

            $obat_eceran_item->save();
            $stok_obat_asal->save();
        }   

        return response($request->all(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ObatEceran::with('obatEceranItem.obatMasuk','obatEceranItem.jenisObat')->findOrFail($id);
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
        $obat_eceran = ObatEceran::with('obatEceranItem')->findOrFail($id);

        $obat_eceran->nama_pembeli = $request->input('nama_pembeli');
        $obat_eceran->alamat = $request->input('alamat');

        date_default_timezone_set('Asia/Jakarta');
        $obat_eceran->waktu_transaksi = date("Y-m-d H:i:s"); // Use default in DB instead?

        $obat_eceran->save();

        foreach ($obat_eceran->obat_eceran_item as $key => $value) {
            $obat_eceran_item = new ObatEceranItem;

            $obat_eceran_item->id_obat_eceran = $value['id_obat_eceran'];
            $obat_eceran_item->id_jenis_obat = $value['id_jenis_obat'];
            $obat_eceran_item->id_obat_masuk = $value['id_obat_masuk'];
            $obat_eceran_item->jumlah = $value['jumlah'];
            $obat_eceran_item->harga_jual_realisasi = $value['harga_jual_realisasi'];
            $obat_eceran_item->keterangan = $value['keterangan'];    

            $stok_obat_asal = StokObat::where('id_obat_masuk', $obat_eceran_item->id_obat_masuk)
                                        ->where('lokasi', 2)
                                        ->first(); //TO-DO: Error handling - firstOrFail?
            $stok_obat_asal->jumlah = ($stok_obat_asal->jumlah) - ($obat_eceran_item->jumlah);

            $obat_eceran_item->save();
            $stok_obat_asal->save();
        }   

        return response ($obat_eceran, 200)
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
        $obat_eceran = ObatEceran::find($id);
        $obat_eceran->delete();
        return response ($id.' deleted', 200);
    }
}
