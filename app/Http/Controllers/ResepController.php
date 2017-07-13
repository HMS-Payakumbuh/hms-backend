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
        return Resep::with('resepItem', 'resepItem.racikanItem','transaksi','transaksi.pasien')->get();
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
        $resep = new Resep;
        $resep->id_transaksi = $value['id_transaksi'];
        $resep->save();

        foreach ($value['resep_item'] as $key => $value) {
          $resep_item = new ResepItem;
          $resep_item->resep_id = $resep->id;
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
        return Resep::with('resepItem', 'resepItem.racikanItem','transaksi','transaksi.pasien')->findOrFail($id);
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
        $resep->id_tindakan = $value['id_tindakan'];
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

    public function searchByTransaksi(Request $request)
    {
        $resep = Resep::where('id_transaksi', $request->input('id_transaksi'))
                                ->get();
        return response ($resep, 200)
                -> header('Content-Type', 'application/json');
    }
}
