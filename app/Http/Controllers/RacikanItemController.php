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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RacikanItem  $racikanItem
     * @return \Illuminate\Http\Response
     */
    public function show(RacikanItem $racikanItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RacikanItem  $racikanItem
     * @return \Illuminate\Http\Response
     */
    public function edit(RacikanItem $racikanItem)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RacikanItem  $racikanItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(RacikanItem $racikanItem)
    {
        //
    }
}
