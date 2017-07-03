<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Klaim;

class KlaimController extends Controller
{
    private function getKlaim($id = null)
    {
        if (isset($id)) {
            return Klaim::findOrFail($id);
        } else {
            return Klaim::all();
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
            'allKlaim' => $this->getKlaim()->toJson()
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
        $payload = $request->input('klaim');
        $klaim = new Klaim;
        $klaim->id_pembayaran = $payload['id_pembayaran'];
        $klaim->id_asuransi = $payload['id_asuransi'];
        $klaim->status = $payload['status'];
        $klaim->tarif = $payload['tarif'];
        $klaim->save();

        return response()->json([
            'klaim' => $klaim->toJson()
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
            'klaim' => $this->getKlaim($id)->toJson()
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
        $payload = $request->input('klaim');
        $klaim = Klaim::findOrFail($id);
        $klaim->id_pembayaran = $payload['id_pembayaran'];
        $klaim->id_asuransi = $payload['id_asuransi'];
        $klaim->status = $payload['status'];
        $klaim->tarif = $payload['tarif'];
        $klaim->save();

        return response()->json([
            'klaim' => $klaim->toJson()
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
        Klaim::destroy($id);
    }
}
