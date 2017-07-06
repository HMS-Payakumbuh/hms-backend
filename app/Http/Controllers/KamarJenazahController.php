<?php

namespace App\Http\Controllers;

use App\KamarJenazah;
use Illuminate\Http\Request;

class KamarJenazahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return KamarJenazah::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kamarJenazah = new KamarJenazah;
        $kamarJenazah->no_kamar = $request->input('no_kamar');
        $kamarJenazah->save();

        return response($kamarJenazah, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function show($no_kamar)
    {
        return KamarJenazah::findOrFail($no_kamar);
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
        $kamarJenazah = KamarJenazah::findOrFail($no_kamar);
        $kamarJenazah->no_kamar = $request->input('no_kamar');
        $kamarJenazah->save();

        return response($kamarJenazah, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function destroy($no_kamar)
    {
        KamarJenazah::destroy($no_kamar);
        return response('', 204);
    }
}
