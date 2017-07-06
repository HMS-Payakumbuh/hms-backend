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
            return Transaksi::with(['pasien', 'tindakan.daftarTindakan', 'pembayaran'])->findOrFail($id);
        } else {
            return Transaksi::with('pasien')->get();
        }
    }


    public function getRecentTransaksi($nama_pasien)
    {
        $transaksi = Transaksi
                            ::join('pasien', 'transaksi.id_pasien', '=', 'pasien.id')
                            ->orderBy('transaksi.waktu_masuk_pasien', 'desc')
                            ->where('nama_pasien', '=', $nama_pasien)
                            ->first();
        return $transaksi;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'allTransaksi' => $this->getTransaksi()
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
        
        if (isset($payload['no_sep'])) {
            $transaksi->no_sep = $payload['no_sep'];
            $coder_nik = SettingBpjs::findOrFail(1)->coder_nik;
            $bpjs =  new BpjsManager($transaksi->no_sep, $coder_nik);
            // $bpjs->newClaim();
            // $bpjs->setClaimData();
        }
        
        $transaksi->kode_jenis_pasien = $payload['kode_jenis_pasien']; //1: pasien umum, 2: pasien asuransi

        if ($payload['kode_jenis_pasien'] == 2) {
            $transaksi->asuransi_pasien = $payload['asuransi_pasien'];
        }
        else {
            $transaksi->asuransi_pasien = 'tunai';
        }
        
        $transaksi->harga_total = 0;
        $transaksi->jenis_rawat = $payload['jenis_rawat']; //1: rawat inap, 2: rawat jalan
        
        if ($transaksi->jenis_rawat == 2) {
            $transaksi->kelas_rawat = 1;
        }
        else {
            $transaksi->kelas_rawat = $payload['kelas_rawat']; //kelas perawatan saat pasien mendaftar
        }
        $transaksi->status_naik_kelas = 1; //1: pasien tidak naik kelas, 2: pasien naik kelas
        $transaksi->status = 'open'; //status transaksi (open/closed)
        $transaksi->save();

        $transaksi = Transaksi::findOrFail($transaksi->id);
        $code_str = strtoupper(base_convert($transaksi->id, 10, 36));
        $code_str = str_pad($code_str, 8, '0', STR_PAD_LEFT);
        $transaksi->no_transaksi = 'INV' . $code_str;
        $transaksi->save();
        
        return response()->json([
            'transaksi' => $transaksi
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
            'transaksi' => $this->getTransaksi($id)
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
        $transaksi->update($payload);

        if ($transaksi->status == 'closed') {
            $coder_nik = SettingBpjs::findOrFail(1)->coder_nik;
            $bpjs =  new BpjsManager($transaksi->no_sep, $coder_nik);
            // $bpjs->finalizeClaim();
        }

        return response()->json([
            'transaksi' => $transaksi
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
