<?php

namespace App\Http\Controllers;

use App\RacikanItem;
use Illuminate\Http\Request;

class RacikanItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RacikanItem::all();
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
            $racikan_item = new RacikanItem;

            $racikan_item->id_item = $value['id_jenis_obat'];
            $racikan_item->id_jenis_obat = $value['id_obat_masuk'];            
            $racikan_item->jumlah = $value['jumlah'];       

            $racikan_item->save();
        }
        return response ($request->all(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RacikanItem  $racikanItem
     * @return \Illuminate\Http\Response
     */
    public function show(RacikanItem $racikanItem)
    {
        return RacikanItem::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RacikanItem  $racikanItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RacikanItem $racikanItem)
    {
        $racikan_item = RacikanItem::findOrFail($id);

        $racikan_item->id_item = $value['id_jenis_obat'];
        $racikan_item->id_jenis_obat = $value['id_obat_masuk'];            
        $racikan_item->jumlah = $value['jumlah'];       

        $racikan_item->save();

        return response ($racikan_item, 200)
            -> header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RacikanItem  $racikanItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(RacikanItem $racikanItem)
    {
        $racikan_item = RacikanItem::find($id);
        $racikan_item->delete();
        return response ($id.' deleted', 200)
    }
}
