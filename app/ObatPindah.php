<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObatPindah extends Model
{
    protected $table = 'obat_pindah';

    /**
    *	Get the JenisObat of the ObatPindah.
    */
    public function jenisObat()
    {
        return $this->belongsTo('App\JenisObat', 'id_jenis_obat');
    }

    /**
    *   Get the StokObatAsal of the ObatPindah.
    */
    public function stokObatAsal()
    {
        return $this->belongsTo('App\StokObat', 'id_stok_obat_asal');
    }

    /**
    *   Get the StokObatTujuan of the ObatPindah.
    */
    public function stokObatTujuan()
    {
        return $this->belongsTo('App\StokObat', 'id_stok_obat_tujuan');
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
