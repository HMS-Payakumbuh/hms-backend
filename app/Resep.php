<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    protected $table = 'resep';
    protected $primaryKey = 'no_resep';

    /**
    *	Get the ResepItem of the Resep
    */
    public function resepItem()
    {
    	return $this->hasMany('App\ResepItem');
    }

    /**
    *	Get the RacikanItem of the Resep
    */
    public function racikanItem()
    {
    	return $this->hasManyThrough('App\ResepItem', 'App\RacikanItem');
    }
}
