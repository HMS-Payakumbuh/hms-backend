<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResepItem extends Model
{
    protected $table = 'resep_item';

    /**
    *	Get the RacikanItem of the ResepItem
    */
    public function racikanItem()
    {
    	return $this->hasMany('App\RacikanItem');
    }
}
