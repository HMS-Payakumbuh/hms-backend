<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObatTindakan extends Model
{
    protected $table = 'obat_tindakan';

    /**
    *   Get the StokObat of the ObatTindakan.
    */
    public function stokObat()
    {
        return $this->belongsTo('App\StokObat', 'id_stok_obat');
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
