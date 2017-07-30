<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StokObat extends Model
{
    protected $table = 'stok_obat';

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
    *   Get the ObatMasuk of the StokObat.
    */
    public function obatMasuk()
    {
        return $this->hasMany('App\ObatMasuk', 'id_stok_obat');
    }

    /**
    *   Get the ObatPindahMasuk of the StokObat.
    */
    public function obatPindahMasuk()
    {
        return $this->hasMany('App\ObatPindah', 'id_stok_obat_tujuan');
    }


    /**
    *   Get the ObatPindahKeluar of the StokObat.
    */
    public function obatPindahKeluar()
    {
        return $this->hasMany('App\ObatPindah', 'id_stok_obat_asal');
    }

    /**
    *   Get the ObatRusak of the StokObat.
    */
    public function obatRusak()
    {
        return $this->hasMany('App\ObatRusak', 'id_stok_obat');
    }

    /**
    *   Get the ObatTindakan of the StokObat.
    */
    public function obatTindakan()
    {
        return $this->hasMany('App\ObatTindakan', 'id_stok_obat');
    }

    /**
    *   Get the ObatEceranItem of the StokObat.
    */
    public function obatEceranItem()
    {
        return $this->hasMany('App\ObatEceranItem', 'id_stok_obat');
    }

    /**
    *   Get the ObatTebusItem of the StokObat.
    */
    public function obatTebusItem()
    {
        return $this->hasMany('App\ObatTebusItem', 'id_stok_obat');
    }

}
