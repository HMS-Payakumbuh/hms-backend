<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransaksiEksternal;

class TransaksiEksternalController extends Controller
{

    private function getTransaksi($id = null) {
        if (isset($id)) {
            return TransaksiEksternal::findOrFail($id);
        }
        else {
            return TransaksiEksternal::get();
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
            'allTransaksi' => $this->getTransaksi();
        ]);
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
        $transaksi = new TransaksiEksternal;
        $transaksi->harga_total = 0;
        $transaksi->status = 'open';
        $transaksi->nama = $payload['nama'];
        $transaksi->alamat = $payload['alamat'];
        $transaksi->no_telepon = $payload['no_telepon'];
        $transaksi->umur = $payload['umur'];
        $transaksi->save();

        $transaksi = Transaksi::findOrFail($transaksi->id);
        $code_str = strtoupper(base_convert($transaksi->id, 10, 36));
        $code_str = str_pad($code_str, 8, '0', STR_PAD_LEFT);
        $transaksi->no_transaksi = 'EKS' . $code_str;
        $transaksi->save();

        return response()->json([
            'transaksi' => $transaksi;
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
            'transaksi' => $this->getTransaksi($id);
        ]);
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
        $transaksi = TransaksiEksternal::findOrFail($id);
        $transaksi->update($payload);

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
        TransaksiEksternal::destroy($id);
    }
}
