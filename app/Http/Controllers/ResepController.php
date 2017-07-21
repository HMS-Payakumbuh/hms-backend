<?php

namespace App\Http\Controllers;

use App\Resep;
use App\ResepItem;
use App\RacikanItem;
use Illuminate\Http\Request;

class ResepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Resep::with('resepItem', 'resepItem.racikanItem', 'resepItem.racikanItem.jenisObat', 'transaksi','transaksi.pasien')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $resep = [];
      $i = 0;
      foreach ($request->all() as $key => $value) {
        $resep[$i] = new Resep;
        $resep[$i]->id_transaksi = $value['id_transaksi'];
        $resep[$i]->eksternal = $value['eksternal'];
        $resep[$i]->nama = $value['nama'];
        $resep[$i]->alamat = $value['alamat'];
        $resep[$i]->nama_dokter = $value['nama_dokter'];
        $resep[$i]->no_telp = $value['no_telp'];
        $resep[$i]->umur = $value['umur'];

        $resep[$i]->save();

        foreach ($value['resep_item'] as $key => $value) {
          $resep_item = new ResepItem;
          $resep_item->resep_id = $resep[$i]->id;
          $resep_item->aturan_pemakaian = $value['aturan_pemakaian'];
          $resep_item->petunjuk_peracikan = $value['petunjuk_peracikan'];
          $resep_item->save();

          foreach($value['racikan_item'] as $key => $value) {
            $racikan_item = new RacikanItem;
            $racikan_item->resep_item_id = $resep_item->id;
            $racikan_item->id_jenis_obat = $value['id_jenis_obat'];
            $racikan_item->jumlah = $value['jumlah'];
            $racikan_item->save();
          }
        }
        $i++;
      }
      return response ($resep, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Resep::with('resepItem', 'resepItem.racikanItem', 'resepItem.racikanItem.jenisObat', 'transaksi','transaksi.pasien')->findOrFail($id);
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
        $resep = Resep::findOrFail($id);
        $resep->id_transaksi = $value['id_transaksi'];
        $resep->eksternal = $value['eksternal'];
        $resep->nama = $value['nama'];
        $resep->alamat = $value['alamat'];
        $resep->nama = $value['nama'];
        $resep->alamat = $value['alamat'];
        $resep->nama_dokter = $value['nama_dokter'];
        $resep->no_telp = $value['no_telp'];
        $resep->umur = $value['umur'];
        $resep->save();

        return response ($resep, 200)
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
        $resep = Resep::find($id);
        $resep->delete();
        return response ($id.' deleted', 200);
    }

 /*   public function searchByTransaksi(Request $request)
    {
        $resep = Resep::with('resepItem', 'resepItem.racikanItem', 'resepItem.racikanItem.jenisObat', 'transaksi','transaksi.pasien')
                                ->where('id_transaksi', $request->input('id_transaksi'))
                                ->get();
        return response ($resep, 200)
                -> header('Content-Type', 'application/json');
    }
*/

    public function searchByPasienAndTanggal(Request $request)
    {
        $resep = Resep::join('transaksi', 'transaksi.id', '=', 'resep.id_transaksi')
                        ->where('transaksi.id_pasien', $request->input('id_pasien'))
                        ->whereDate('created_at', '=', $request->input('tanggal_resep'))
                        ->select('resep.*')
                        ->get();
        return response ($resep, 200)
                -> header('Content-Type', 'application/json');
    }
}
