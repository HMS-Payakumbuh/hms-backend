<?php

namespace App\Http\Controllers;

use App\KamarOperasi;
use Illuminate\Http\Request;

class KamarOperasi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return KamarOperasi::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kamarOperasi = new KamarOperasi;
        $kamarOperasi->no_kamar = $request->input('no_kamar');
        $kamarOperasi->save();

        return response($kamarOperasi, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function show($no_kamar)
    {
        return KamarOperasi::findOrFail($no_kamar);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $no_kamar)
    {
        $kamarOperasi = KamarOperasi::findOrFail($no_kamar);
        $kamarOperasi->no_kamar = $request->input('no_kamar');
        $kamarOperasi->save();

        return response($kamarOperasi, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function destroy($no_kamar)
    {
        KamarOperasi::destroy($no_kamar);
        return response('', 204);
    }
}
