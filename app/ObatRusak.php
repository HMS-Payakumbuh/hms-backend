<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObatRusak extends Model
{
    protected $table = 'obat_rusak';

    /**
    *	Get the ObatMasuk of the ObatRusak.
    */
    public function obatMasuk()
    {
        return $this->belongsTo('App\ObatMasuk', 'id_obat_masuk');
    }

    /**
    *	Get the JenisObat of the ObatRusak.
    */
    public function jenisObat()
    {
        return $this->belongsTo('App\JenisObat', 'id_jenis_obat');
    }

    /**
    *   Get the StokObat of the ObatRusak.
    */
    public function stokObat()
    {
        return $this->belongsTo('App\StokObat', 'id_stok_obat');
    }

    /**
    *	Get the LokasiAsal of the ObatRusak.
    */
    public function lokasiAsal()
    {
        return $this->belongsTo('App\LokasiObat', 'asal');
    }
}
