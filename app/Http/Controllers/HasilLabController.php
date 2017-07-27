<?php

namespace App\Http\Controllers;

use App\HasilLab;
use Illuminate\Http\Request;

class HasilLabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return HasilLab::with('transaksi', 'tindakan', 'tindakan.daftarTindakan', 'tindakan.pasien')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $hasilLab = new HasilLab;
      $hasilLab->id_transaksi = $request->input('id_transaksi');
      $hasilLab->id_tindakan = $request->input('id_tindakan');
      $hasilLab->dokumen = $request->dokumen->store('hasil_lab');
      $hasilLab->save();
      return response($hasilLab, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $kode_pasien
     * @return \Illuminate\Http\Response
     */
    public function show($kode_pasien)
    {
      return HasilLab::with('transaksi', 'tindakan', 'tindakan.daftarTindakan', 'tindakan.pasien')
        ->whereHas('tindakan.pasien', function ($query) use ($kode_pasien) {
          $query->where('kode_pasien', 'like', '%'.$kode_pasien.'%');
        })
        ->get();
    }

    /**
     * Downloads file.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
      $file = HasilLab::findOrFail($id)->dokumen;
      return response()->download(storage_path().'/app/'.$file);
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
      $hasilLab = HasilLab::findOrFail($id);
      $hasilLab->id_transaksi = $hasilLab->id_transaksi;
      $hasilLab->id_tindakan = $hasilLab->id_tindakan;
      $hasilLab->dokumen = $request->dokumen->store('hasil_lab');
      $hasilLab->save();
      return response($hasilLab, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      HasilLab::destroy($id);
      return response('', 204);
    }
}
