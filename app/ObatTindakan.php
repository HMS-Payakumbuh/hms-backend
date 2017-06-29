<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObatTindakan extends Model
{
    protected $table = 'obat_tindakan';

    /**
    *	Get the ObatMasuk of the ObatTindakan.
    */
    public function obatMasuk()
    {
        return $this->belongsTo('App\ObatMasuk', 'id_obat_masuk');
    }

    /**
    *	Get the JenisObat of the ObatTindakan.
    */
    public function jenisObat()
    {
        return $this->belongsTo('App\JenisObat', 'id_jenis_obat');
    }

    /**
    *	Get the LokasiAsal of the ObatTindakan.
    */
    public function lokasiAsal()
    {
        return $this->belongsTo('App\LokasiObat', 'asal');
    }
}
