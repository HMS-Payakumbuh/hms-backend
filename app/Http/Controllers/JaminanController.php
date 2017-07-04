<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jaminan;

class JaminanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Jaminan::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payload = $request->input('jaminan');
        $jaminan = new Jaminan;
        $jaminan->payor_id = $payload['payor_id'];
        $jaminan->payor_cd = $payload['payor_cd'];
        $jaminan->payor_nama = $payload['payor_nama'];
        $jaminan->save();

        return response()->json([
            'jaminan' => $jaminan->toJson()
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
        return Jaminan::findOrFail($id);
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
        $payload = $request->input('jaminan');
        $jaminan = Jaminan::findOrFail($id);
        $jaminan->payor_id = $payload['payor_id'];
        $jaminan->payor_cd = $payload['payor_cd'];
        $jaminan->payor_nama = $payload['payor_nama'];
        $jaminan->save();

        return response()->json([
            'jaminan' => $jaminan->toJson()
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
        return Jaminan::destroy($id);
    }
}
