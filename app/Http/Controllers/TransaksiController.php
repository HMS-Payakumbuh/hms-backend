<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\BpjsManager;
use App\SettingBpjs;

class TransaksiController extends Controller
{
    private function getTransaksi($id = null)
    {
        if (isset($id)) {
            return Transaksi::findOrFail($id);
        } else {
            return Transaksi::all();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'allTransaksi' => $this->getTransaksi()->toJson()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payload = $request->input('transaksi');
        $transaksi = new Transaksi;
        $transaksi->id_pasien = $payload['id_pasien'];
        $transaksi->no_transaksi = str_random(8);
        $transaksi->no_sep = $payload['no_sep'];
        $transaksi->harga_total = 0;
        $transaksi->asuransi_pasien = $payload['asuransi_pasien'];
        $transaksi->kode_jenis_pasien = $payload['kode_jenis_pasien']; //1: pasien umum, 2: pasien asuransi
        $transaksi->jenis_rawat = $payload['jenis_rawat']; //1: rawat inap, 2: rawat jalan
        $transaksi->kelas_rawat = $payload['kelas_rawat']; //kelas perawatan saat pasien mendaftar
        $transaksi->status_naik_kelas = 1; //1: pasien tidak naik kelas, 2: pasien naik kelas
        $transaksi->status = 'open'; //status transaksi (open/closed)
        $transaksi->save();

        $coder_nik = SettingBpjs::findOrFail(1)->coder_nik;
        $bpjs =  new BpjsManager($transaksi->no_sep, $coder_nik);
        
        
        return response()->json([
            'transaksi' => $transaksi->toJson()
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'transaksi' => $this->getTransaksi($id)->toJson()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $payload = $request->input('transaksi');
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->id_pasien = $payload['id_pasien'];
        $transaksi->no_transaksi = $payload['no_transaksi'];
        $transaksi->no_sep = $payload['no_sep'];
        $transaksi->harga_total = $payload['harga_total'];
        $transaksi->asuransi_pasien = $payload['asuransi_pasien'];
        $transaksi->kode_jenis_pasien = $payload['kode_jenis_pasien']; //1: pasien umum, 2: pasien asuransi
        $transaksi->jenis_rawat = $payload['jenis_rawat']; //1: rawat inap, 2: rawat jalan
        $transaksi->kelas_rawat = $payload['kelas_rawat']; //kelas perawatan saat pasien mendaftar
        $transaksi->status_naik_kelas = $payload['status_naik_kelas']; //1: pasien tidak naik kelas, 2: pasien naik kelas
        $transaksi->status = $payload['status']; //status transaksi (open/closed)
        $transaksi->save();

        return response()->json([
            'transaksi' => $transaksi->toJson()
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transaksi::destroy($id);
    }
}
