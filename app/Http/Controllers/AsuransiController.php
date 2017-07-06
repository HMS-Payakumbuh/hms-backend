<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asuransi;

class AsuransiController extends Controller
{
    private function getAsuransi($id = null)
    {
        if (isset($id)) {
            return Asuransi::findOrFail($id);
        } else {
            return Asuransi::all();
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
            'allAsuransi' => $this->getAsuransi()
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
        $payload = $request->input('asuransi');
        $asuransi = new Asuransi;
        $asuransi->id_pasien = $payload['id_pasien'];
        $asuransi->no_kartu = $payload['no_kartu'];
        $asuransi->nama_asuransi = $payload['nama_asuransi'];
        $asuransi->save();

        return response()->json([
            'asuransi' => $asuransi
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
            'asuransi' => $this->getAsuransi($id)
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
        $payload = $request->input('asuransi');
        $asuransi = Asuransi::findOrFail($id);
        $asuransi->no_kartu = $payload['no_kartu'];
        $asuransi->save();
        
        return response()->json([
            'asuransi' => $asuransi
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
        Asuransi::destroy($id);
    }
}
