<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cob;

class CobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Cob::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payload = $request->input('cob');
        $cob = new Cob;
        $cob->cd_cob = $payload['cd_cob'];
        $cob->nama_cob = $payload['nama_cob'];
        $cob->save();

        return response()->json([
            'cob' => $cob->toJson()
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
        return Cob::findOrFail($id);
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
        $payload = $request->input('cob');
        $cob = Cob::findOrFail($id);
        $cob->cd_cob = $payload['cd_cob'];
        $cob->nama_cob = $payload['nama_cob'];
        $cob->save();

        return response()->json([
            'cob' => $cob->toJson()
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
        return Cob::destroy($id);
    }
}
