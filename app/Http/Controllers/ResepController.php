<?php

namespace App\Http\Controllers;

use App\Resep;
use App\ResepItem;
use App\RacikanItem;
use Illuminate\Http\Request;
use App\TransaksiEksternal;
use App\Transaksi;

class ResepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Resep::with('resepItem', 'resepItem.racikanItem', 'resepItem.racikanItem.jenisObat', 'transaksi','transaksi.pasien','transaksiEksternal')->get();
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
        $resep[$i]->eksternal = $value['eksternal'];
        
        if ($value['id_transaksi']) {      
            $resep[$i]->id_transaksi = $value['id_transaksi'];   
        } else {
            if ($resep[$i]->eksternal) {
                $transaksi = new TransaksiEksternal;             
                $transaksi->harga_total = 0;
                $transaksi->status = 'open';
                $transaksi->nama = $value['nama'];
                $transaksi->alamat = $value['alamat'];
                $transaksi->no_telepon = $value['no_telepon'];
                $transaksi->umur = $value['umur'];
                $transaksi->save();

                $transaksi = TransaksiEksternal::findOrFail($transaksi->id);
                $code_str = strtoupper(base_convert($transaksi->id, 10, 36));
                $code_str = str_pad($code_str, 8, '0', STR_PAD_LEFT);
                $transaksi->no_transaksi = 'EKS' . $code_str;
                $transaksi->save();

                $resep[$i]->id_transaksi_eksternal = $transaksi->id;
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

                $resep[$i]->id_transaksi = $transaksi->id;
            }
        }
        
        $resep[$i]->nama_dokter = $value['nama_dokter'];
        $resep[$i]->tebus = $value['tebus'];

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
        return Resep::with('resepItem', 'resepItem.racikanItem', 'resepItem.racikanItem.jenisObat', 'transaksi','transaksi.pasien', 'transaksiEksternal')->findOrFail($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id_pasien
     * @param  string  $tanggal_waktu
     * @return \Illuminate\Http\Response
     */
    public function getResepOfRekamMedis($id_pasien, $tanggal_waktu)
    {
        $with_condition = function ($query) use ($id_pasien, $tanggal_waktu) {
           $query->where('id_pasien', $id_pasien);
           $query->where('waktu_masuk_pasien', $tanggal_waktu);
        };
        return Resep::with('resepItem', 'resepItem.racikanItem', 'resepItem.racikanItem.jenisObat', 'transaksi')
        ->whereHas('transaksi', $with_condition)
        ->get();
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
        $resep->id_transaksi_eksternal = $value['id_transaksi_eksternal'];   
        $resep->eksternal = $value['eksternal'];
        $resep->nama_dokter = $value['nama_dokter'];
        $resep->tebus = $value['tebus'];
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

/*    public function searchByPasienAndTanggal(Request $request)
    {
        $resep = Resep::join('transaksi', 'transaksi.id', '=', 'resep.id_transaksi')
                        ->where('transaksi.id_pasien', $request->input('id_pasien'))
                        ->whereDate('created_at', '=', $request->input('tanggal_resep'))
                        ->select('resep.*')
                        ->get();
        return response ($resep, 200)
                -> header('Content-Type', 'application/json');
    }
*/

    public function searchByPasien(Request $request)
    {
        $resep = Resep::join('transaksi', 'transaksi.id', '=', 'resep.id_transaksi')
                        ->where('transaksi.id_pasien', $request->input('id_pasien'))
                        ->where('resep.tebus', '=', false)
                        ->select('resep.*')
                        ->get();
        return response ($resep, 200)
                -> header('Content-Type', 'application/json');
    }
}
