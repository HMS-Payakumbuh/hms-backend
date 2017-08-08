<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RekamMedisEksternal extends Model
{
    protected $table = 'rekam_medis_eksternal';

    public function pasien()
	{
		return $this->belongsTo('App\Pasien', 'id_pasien');
	}
}