<?php

namespace App\Http\Controllers;

use App\ResepItem;
use Illuminate\Http\Request;

class ResepItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ResepItem::with('racikanItem')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            $resep_item = new RacikanItem;

            $resep_item->no_resep = $value['no_resep'];
            $resep_item->aturan_pemakaian = $value['aturan_pemakaian'];            
            $resep_item->petunjuk_peracikan = $value['petunjuk_peracikan'];       

            $resep_item->save();
        }
        return response ($request->all(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ResepItem::with('racikanItem')->findOrFail($id);
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
        $resep_item = ResepItem::findOrFail($id);

        $resep_item->no_resep = $value['no_resep'];
        $resep_item->aturan_pemakaian = $value['aturan_pemakaian'];            
        $resep_item->petunjuk_peracikan = $value['petunjuk_peracikan'];   

        $resep_item->save();

        return response ($resep_item, 200)
            -> header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resep_item = ResepItem::find($id);
        $resep_item->delete();
        return response ($id.' deleted', 200);
    }
}
