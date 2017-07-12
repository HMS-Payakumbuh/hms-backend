<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObatTebusItem extends Model
{
    protected $table = 'obat_tebus_item';

    /**
    *	Get the ObatMasuk of the ObatTebusItem.
    */
    public function obatMasuk()
    {
        return $this->belongsTo('App\ObatMasuk', 'id_obat_masuk');
    }

    /**
    *	Get the JenisObat of the ObatTebusItem.
    */
    public function jenisObat()
    {
        return $this->belongsTo('App\JenisObat', 'id_jenis_obat');
    }

    /**
    *	Get the LokasiAsal of the ObatTebusItem.
    */
    public function lokasiAsal()
    {
        return $this->belongsTo('App\LokasiObat', 'asal');
    }

    /**
    *   Get the RacikanItem of the ObatTebusItem.
    */
    public function racikanItem()
    {
        return $this->belongsTo('App\RacikanItem', 'id_racikan_item');
    }
}
