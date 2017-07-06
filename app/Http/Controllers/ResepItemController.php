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
        //
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
     * @param  \App\ResepItem  $resepItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ResepItem $resepItem)
    {
        //
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
