<?php

namespace App\Http\Controllers;

use App\TempatTidur;
use Illuminate\Http\Request;

class TempatTidur extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TempatTidur::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tempatTidur = new TempatTidur;
        $tempatTidur->no_kamar = $request->input('no_kamar');
        $tempatTidur->no_tempat_tidur = $request->input('no_tempat_tidur');
        $tempatTidur->status = $request->input('status');
        $tempatTidur->save();

        return response($tempatTidur, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function show($no_kamar)
    {
        return TempatTidur::findOrFail($no_kamar);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $no_kamar
     * @param  string  $no_tempat_tidur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $no_kamar, $no_tempat_tidur)
    {
        $tempatTidur = TempatTidur::where('no_kamar', '=', $no_kamar)
        ->where('no_tempat_tidur', '=', $no_tempat_tidur)
        ->first();

        $tempatTidur->status = $request->input('status');
        $tempatTidur->save();

        return response($tempatTidur, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    // public function destroy($no_kamar)
    // {
    //     KamarRawatinap::destroy($no_kamar);
    //     return response('', 204);
    // }
}
