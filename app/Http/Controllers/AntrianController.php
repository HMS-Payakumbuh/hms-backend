<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Antrian;
use Carbon\Carbon;

class AntrianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Antrian::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $antrian = new Antrian;
        $antrian->id_transaksi = $request->input('id_transaksi');
        $antrian->nama_layanan_poli = $request->input('nama_layanan_poli');
        $antrian->nama_layanan_lab = $request->input('nama_layanan_lab');
        $antrian->jenis = $request->input('jenis');
        $antrian->status = 0;
        $antrian->save();

        return response($antrian, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $nama_layanan
     * @return \Illuminate\Http\Response
     */
    public function show($nama_layanan)
    {
        return Antrian::where('nama_layanan_poli', '=', $nama_layanan)
	      ->orWhere('nama_layanan_lab', '=', $nama_layanan)
          ->where('status', '=', 0)
          ->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  integer  $id_transaksi
     * @param  string  $no_antrian
     * @return \Illuminate\Http\Response
     */
    public function update($id_transaksi, $no_antrian)
    {
		$antrian = Antrian::where('id_transaksi', '=', $id_transaksi)
        ->where('no_antrian', '=', $no_antrian)
        ->first();
        
        $antrian->waktu_perubahan_antrian = Carbon::now();
        $antrian->save();
		return response($antrian, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $id_transaksi
     * @param  string  $no_antrian
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_transaksi, $no_antrian)
    {
		$deletedRows = Antrian::where('id_transaksi', '=', $id_transaksi)
	    ->where('no_antrian', '=', $no_antrian)
	    ->first()
	    ->delete();
        return response('', 204);
    }
}
