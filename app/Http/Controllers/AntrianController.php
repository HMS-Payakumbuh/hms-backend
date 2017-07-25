<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Antrian;
use App\Transaksi;
use App\Pasien;
use App\Asuransi;
use App\Poliklinik;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

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

    	$transaksi = Transaksi::findOrFail($request->input('id_transaksi'));
	    if ($transaksi) {
	    	$pasien = Pasien::findOrFail($transaksi->id_pasien);
	    	if ($pasien) {
	    		$age = $pasien->age();
		    	if ($age >= 65)
		    		$antrian->jenis = 1;
		    	else
		    		$antrian->jenis = 0;
	    	}
	    }

        $antrian->id_transaksi = $request->input('id_transaksi');
        $antrian->nama_layanan_poli = $request->input('nama_layanan_poli');
        $antrian->nama_layanan_lab = $request->input('nama_layanan_lab');
        $antrian->status = 0;
        $antrian->kesempatan = $request->input('kesempatan');
        $antrian->save();

        if ($request->input('nama_layanan_poli')) {
            $poli = Poliklinik::findOrFail($request->input('nama_layanan_poli'));
            if ($poli && $poli->sisa_pelayanan > 0) {
                $poli->sisa_pelayanan = $poli->sisa_pelayanan - 1;
                $poli->save();
            } else {
                Antrian::destroy($antrian->id_transaksi, $antrian->no_antrian);
                Transaksi::destroy($antrian->id_transaksi);
                Pasien::destroy($request->input('id_pasien'));
                if ($request->input('id_asuransi'))
                    Asuransi::destroy($request->input('id_asuransi'));
                return response()->json([
                    'error' => "Pembuatan Antrian Gagal"
                ], 500);
            }
        }
        Redis::publish('antrian', json_encode(['kategori_antrian' => '']));
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
        return Antrian::where([['status', '=', 0], ['nama_layanan_poli', '=', $nama_layanan]])
          ->orWhere([['status', '=', 0], ['nama_layanan_lab', '=', $nama_layanan]])
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
        $antrian->kesempatan = $antrian->kesempatan - 1;
        $antrian->save();
        if ($antrian->kesempatan <= 0)
            $antrian->delete();
        Redis::publish('antrian', json_encode(['kategori_antrian' => '']));
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
		$antrian = Antrian::where('id_transaksi', '=', $id_transaksi)
	    ->where('no_antrian', '=', $no_antrian)
	    ->first();
	    $antrian->status = 1;
        $antrian->save();
        Redis::publish('antrian', json_encode(['kategori_antrian' => '']));
        return response($antrian, 204);
    }
}
