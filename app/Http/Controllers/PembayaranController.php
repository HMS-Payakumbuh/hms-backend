<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembayaran;

class PembayaranController extends Controller
{
    private function getPembayaran($id = null)
    {
        if (isset($id)) {
            return Pembayaran::findOrFail($id);
        } else {
            return Pembayaran::all();
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
            'allPembayaran' => $this->getPembayaran()->toJson()
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
        $payload = $request->input('pembayaran');
        $pembayaran = new Pembayaran;
        $pembayaran->id_transaksi = $payload->id_transaksi;
        $pembayaran->harga_bayar = $payload->harga_bayar;
        $pembayaran->metode_bayar = $payload->metode_bayar;
        $pembayaran->save();

        return response()->json([
            'pembayaran' => $pembayaran->toJson()
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
            'pembayaran' => $this->getPembayaran($id)->toJson()
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
        $payload = $request->input('pembayaran');
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->id_transaksi = $payload->id_transaksi;
        $pembayaran->harga_bayar = $payload->harga_bayar;
        $pembayaran->metode_bayar = $payload->metode_bayar;
        $pembayaran->save();

        return response()->json([
            'pembayaran' => $pembayaran->toJson()
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
        Pembayaran::destroy($id);
    }
}
