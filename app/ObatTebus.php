<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObatTebus extends Model
{
    protected $table = 'obat_tebus';

    /**
    *	Get the ObatTebusItem of the ObatTebus.
    */
    public function obatTebusItem()
    {
        return $this->hasMany('App\ObatTebusItem', 'id_obat_tebus');
    }
}
