<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Antrian;
use App\Transaksi;
use App\Pasien;
use App\Asuransi;
use App\Poliklinik;
use App\Rujukan;
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

    public function cleanup()
    {
        $all_antrian = Antrian::where('status', '=', 0)
                ->orWhere('status', '=', 1)
                ->get();
        foreach ($all_antrian as $antrian) {
            $antrian->status = 2;
            $antrian->save();
        }
        //DB::statement('ALTER SEQUENCE antrian_id_seq RESTART WITH 1');  
        return response('', 204);
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

        $all_antrian = Antrian::all();
        if (!empty($all_antrian[0])) {
            if ($all_antrian[count($all_antrian) - 1]->waktu_masuk_antrian < Carbon::today()->toDateTimeString()) {
                self::cleanup();
            }
        } 

    	$transaksi = Transaksi::findOrFail($request->input('id_transaksi'));
	    if ($transaksi) {
	    	$pasien = Pasien::findOrFail($transaksi->id_pasien);
	    	if ($pasien) {
	    		/*$age = $pasien->age();
		    	if ($age >= 65)
		    		$antrian->jenis = 1;
		    	else
		    		$antrian->jenis = 0;*/
                if ($pasien->catatan_kematian) {
                    Transaksi::destroy($request->input('id_transaksi'));
                    $rujukan = Rujukan::where('id_transaksi', '=', $request->input('id_transaksi'))->first();
                    if ($rujukan)
                        Rujukan::destroy($request->input('id_transaksi'));
                    return response()->json([
                        'error' => "Pasien sudah meninggal."
                    ], 202);
                }    
	    	}
	    }

        $antrian->jenis = 0;

        $all_antrian = [];
        if ($request->input('nama_layanan_poli')) {
            $all_antrian = Antrian::where('nama_layanan_poli', '=', $request->input('nama_layanan_poli'))->get();
        } else if ($request->input('nama_layanan_lab')) {
            $all_antrian = Antrian::where('nama_layanan_lab', '=', $request->input('nama_layanan_lab'))->get();
        }

        if (!empty($all_antrian[0])) {
            if ($all_antrian[count($all_antrian) - 1]->waktu_masuk_antrian < Carbon::today()->toDateTimeString())
                $antrian->no_antrian = 1;
            else
                $antrian->no_antrian = $all_antrian[count($all_antrian) - 1]->no_antrian + 1;
        } else {
            $antrian->no_antrian = 1;
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
                $rujukan = Rujukan::where('id_transaksi', '=', $request->input('id_transaksi'))->first();
                if ($rujukan)
                    Rujukan::destroy($request->input('id_transaksi'));
                return response()->json([
                    'error' => "Kuota layanan yang dituju sudah habis."
                ], 202);
            }
        }
        if ($request->input('nama_layanan_poli'))
            Redis::publish('antrian', json_encode(['nama_layanan' => $antrian->nama_layanan_poli]));
        else if ($request->input('nama_layanan_lab'))
            Redis::publish('antrian', json_encode(['nama_layanan' => $antrian->nama_layanan_lab]));

        return response($antrian, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $nama_layanan
     * @return \Illuminate\Http\Response
     */
    public function show($nama_layanan, $status = null)
    {
      return Antrian::with(['transaksi.pasien'])
      ->where([
        ['status', '=', 0],
        ['nama_layanan_poli', '=', $nama_layanan],
        ['waktu_perubahan_antrian', '>=', date('Y-m-d').' 00:00:00']
      ])
      ->orWhere([
        ['status', '=', 0],
        ['nama_layanan_lab', '=', $nama_layanan],
        ['waktu_perubahan_antrian', '>=', date('Y-m-d').' 00:00:00']
      ])
      ->with('transaksi', 'transaksi.pasien')
      ->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $nama_layanan
     * @param  int     $status
     * @return \Illuminate\Http\Response
     */
    public function getAntrianWithStatus($nama_layanan, $status)
    {
      return Antrian::with('transaksi', 'transaksi.pasien')
        ->where([
          ['status', '=', $status],
          ['nama_layanan_poli', '=', $nama_layanan],
          ['waktu_masuk_antrian', '>=', date('Y-m-d').' 00:00:00']
        ])
        ->orWhere([
          ['status', '=', $status],
          ['nama_layanan_lab', '=', $nama_layanan],
          ['waktu_masuk_antrian', '>=', date('Y-m-d').' 00:00:00']
        ])
        ->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function processAntrian(Request $request, $id_transaksi, $no_antrian) {
      $antrian = Antrian::where('id_transaksi', '=', $id_transaksi)
        ->where('no_antrian', '=', $no_antrian)
  	    ->first();
      $antrian->status = 2;
      $antrian->save();
      return response($antrian, 200);
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

        if ($antrian->nama_layanan_poli)
            $antrian_layanan = Antrian::
                where('nama_layanan_poli', '=', $antrian->nama_layanan_poli)
                ->where('status', '<', 2)
                ->get();
        else if ($antrian->nama_layanan_lab)            
            $antrian_layanan = Antrian::
                where('nama_layanan_lab', '=', $antrian->nama_layanan_lab)
                ->where('status', '<', 2)
                ->get();

         if (count($antrian_layanan) >= 5)    
            $antrian->waktu_perubahan_antrian = $antrian_layanan[5]->waktu_perubahan_antrian->addSeconds(1);
        else
            $antrian->waktu_perubahan_antrian = $antrian_layanan[count($antrian_layanan) - 1]->waktu_perubahan_antrian->addSeconds(1);        

        $antrian->kesempatan = $antrian->kesempatan - 1;
        $antrian->save();
        if ($antrian->kesempatan <= 0)
            $antrian->delete();
        if ($antrian->nama_layanan_poli)
            Redis::publish('antrian', json_encode(['nama_layanan' => $antrian->nama_layanan_poli]));
        else if ($antrian->nama_layanan_lab)
            Redis::publish('antrian', json_encode(['nama_layanan' => $antrian->nama_layanan_lab]));

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
        if ($antrian->nama_layanan_poli)
            Redis::publish('antrian', json_encode(['nama_layanan' => $antrian->nama_layanan_poli]));
        else if ($antrian->nama_layanan_lab)
            Redis::publish('antrian', json_encode(['nama_layanan' => $antrian->nama_layanan_lab]));
        return response($antrian, 204);
    }
}
