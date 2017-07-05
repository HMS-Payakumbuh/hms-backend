<?php

namespace App\Http\Controllers;

use App\PemakaianKamarOperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemakaianKamarOperasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemakaianKamarOperasi = PemakaianKamarOperasi
                            ::join('transaksi', 'pemakaian_kamar_operasi.no_transaksi', '=', 'transaksi.id')
                            ->join('tindakan', 'pemakaian_kamar_operasi.no_tindakan', '=', 'tindakan.no_tindakan')
                            ->join('pasien', 'transaksi.id_pasien', '=', 'pasien.id')
                            ->join('tenaga_medis', 'tindakan.np_tenaga_medis', '=', 'tenaga_medis.no_pegawai')
                            ->select(DB::raw('pemakaian_kamar_operasi.no_kamar, pasien.nama_pasien, tenaga_medis.nama, pemakaian_kamar_operasi.waktu_masuk, pemakaian_kamar_operasi.waktu_keluar'))
                            ->get();          


        return $pemakaianKamarOperasi;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pemakaianKamarOperasi = new PemakaianKamarOperasi;
        $pemakaianKamarOperasi->no_kamar = $request->input('no_kamar');
        $pemakaianKamarOperasi->no_tindakan = $request->input('no_tindakan');
        $pemakaianKamarOperasi->no_transaksi = $request->input('no_transaksi');
        $pemakaianKamarOperasi->no_pembayaran = $request->input('no_pembayaran');
        $pemakaianKamarOperasi->waktu_masuk = $request->input('waktu_masuk');
        $pemakaianKamarOperasi->waktu_keluar = null;
        $pemakaianKamarOperasi->harga = $request->input('harga');
        $pemakaianKamarOperasi->save();

        return response($pemakaianKamarOperasi, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function show($no_kamar)
    {
        return PemakaianKamarOperasi::findOrFail($no_kamar);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $no_kamar
     * @param  integer $no_tindakan
     * @param  integer  $no_transaksi
     * @param  datetime  $waktu_masuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $no_kamar, $no_tindakan, $no_transaksi, $waktu_masuk)
    {
        $pemakaianKamarOperasi = PemakaianKamarOperasi ::where('no_kamar', '=', $no_kamar)
        ->where('no_tindakan', '=', $no_tindakan)
        ->where('no_transaksi', '=', $no_transaksi)
        ->where('waktu_masuk', '=', $waktu_masuk)
        ->first();

        $pemakaianKamarOperasi->no_kamar = $request->input('no_kamar');
        $pemakaianKamarOperasi->no_tindakan = $request->input('no_tindakan');
        $pemakaianKamarOperasi->no_transaksi = $request->input('no_transaksi');
        $pemakaianKamarOperasi->no_pembayaran = $request->input('no_pembayaran');
        $pemakaianKamarOperasi->waktu_masuk = $request->input('waktu_masuk');
        $pemakaianKamarOperasi->waktu_keluar = $request->input('waktu_keluar');
        $pemakaianKamarOperasi->harga = $request->input('harga');
        $pemakaianKamarOperasi->save();

        return response($pemakaianKamarOperasi, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $no_kamar
     * @param  integer $no_tindakan
     * @param  integer  $no_transaksi
     * @param  datetime  $waktu_masuk
     * @return \Illuminate\Http\Response
     */
    public function destroy($no_kamar, $no_tindakan, $no_transaksi, $waktu_masuk)
    {
         $deletedRows = PemakaianKamarOperasi ::where('no_kamar', '=', $no_kamar)
        ->where('no_tindakan', '=', $no_tindakan)
        ->where('no_transaksi', '=', $no_transaksi)
        ->where('waktu_masuk', '=', $waktu_masuk)
        ->first()
        ->delete();

        return response('', 204);

    }
}
