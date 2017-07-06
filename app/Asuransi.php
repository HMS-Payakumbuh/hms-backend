<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asuransi extends Model
{
    protected $table = 'asuransi';

    public function pasien()
	{
		return $this->belongsTo('App\Pasien', 'id_pasien');
	}
}
