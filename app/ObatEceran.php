<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObatEceran extends Model
{
    protected $table = 'obat_eceran';

    /**
    *	Get the ObatEceranItem of the ObatEceran
    */
    public function obatEceranItem()
    {
    	return $this->hasMany('App\ObatEceranItem', 'id_obat_eceran');
    }

    /**
    *	Get the TransaksiEksternal of the ObatEceran
    */
    public function transaksiEksternal()
    {
    	return $this->belongsTo('App\TransaksiEksternal', 'id_transaksi');
    }
}
