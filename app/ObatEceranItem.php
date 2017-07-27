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
    *   Get the StokObat of the ObatEceranItem.
    */
    public function stokObat()
    {
        return $this->belongsTo('App\StokObat', 'id_stok_obat');
    }
}
