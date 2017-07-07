<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObatEceranItem extends Model
{
    protected $table = 'obat_eceran_item';

    /**
    *	Get the JenisObat of the ObatEceranItem
    */
    public function jenisObat()
    {
    	return $this->belongsTo('App\JenisObat', 'id_jenis_obat');
    }

    /**
    *	Get the ObatMasuk of the ObatEceranItem
    */
    public function obatMasuk()
    {
    	return $this->belongsTo('App\ObatMasuk', 'id_obat_masuk');
    }
}
