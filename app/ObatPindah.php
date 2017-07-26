<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObatPindah extends Model
{
    protected $table = 'obat_pindah';

    /**
    *	Get the ObatMasuk of the ObatPindah.
    */
    public function obatMasuk()
    {
        return $this->belongsTo('App\ObatMasuk', 'id_obat_masuk');
    }

    /**
    *	Get the JenisObat of the ObatPindah.
    */
    public function jenisObat()
    {
        return $this->belongsTo('App\JenisObat', 'id_jenis_obat');
    }

    /**
    *   Get the StokObat of the ObatPindah.
    */
    public function stokObat()
    {
        return $this->belongsTo('App\StokObat', 'id_stok_obat');
    }

    /**
    *	Get the LokasiAsal of the ObatPindah.
    */
    public function lokasiAsal()
    {
        return $this->belongsTo('App\LokasiObat', 'asal');
    }

    /**
    *	Get the LokasiTujuan of the ObatPindah.
    */
    public function lokasiTujuan()
    {
        return $this->belongsTo('App\LokasiObat', 'tujuan');
    }
}
