<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObatTebusItem extends Model
{
    protected $table = 'obat_tebus_item';

    /**
    *	Get the ObatMasuk of the ObatTebus.
    */
    public function obatMasuk()
    {
        return $this->belongsTo('App\ObatMasuk', 'id_obat_masuk');
    }

    /**
    *	Get the JenisObat of the ObatTebus.
    */
    public function jenisObat()
    {
        return $this->belongsTo('App\JenisObat', 'id_jenis_obat');
    }

    /**
    *	Get the LokasiAsal of the ObatTebus.
    */
    public function lokasiAsal()
    {
        return $this->belongsTo('App\LokasiObat', 'asal');
    }
}
