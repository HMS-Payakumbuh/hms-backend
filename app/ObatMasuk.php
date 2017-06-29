<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObatMasuk extends Model
{
    protected $table = 'obat_masuk';

    /**
    *	Get the JenisObat of the ObatMasuk.
    */
    public function jenisObat()
    {
        return $this->belongsTo('App\JenisObat', 'id_jenis_obat');
    }
}
