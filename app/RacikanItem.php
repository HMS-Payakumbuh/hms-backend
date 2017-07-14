<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RacikanItem extends Model
{
    protected $table = 'racikan_item';

    /**
    *	Get the JenisObat of the RacikanItem.
    */
    public function jenisObat()
    {
        return $this->belongsTo('App\JenisObat', 'id_jenis_obat');
    }
}
