<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StokObat extends Model
{
    protected $table = 'stok_obat';

    /**
    *	Get the ObatMasuk of the StokObat.
    */
    public function obatMasuk()
    {
        return $this->belongsTo('App\ObatMasuk', 'id_obat_masuk');
    }

    /**
    *	Get the JenisObat of the StokObat.
    */
    public function jenisObat()
    {
        return $this->belongsTo('App\JenisObat', 'id_jenis_obat');
    }

    /**
    *	Get the LokasiData of the StokObat.
    */
    public function lokasiData()
    {
        return $this->belongsTo('App\LokasiObat', 'lokasi');
    }

    /**
    *   Get the ObatPindah of the StokObat.
    */
    public function obatPindah()
    {
        return $this->hasMany('App\ObatPindah', 'id_stok_obat');
    }

    /**
    *   Get the ObatRusak of the StokObat.
    */
    public function obatRusak()
    {
        return $this->hasMany('App\ObatRusak', 'id_stok_obat');
    }
}
