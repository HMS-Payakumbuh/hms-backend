<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $table = 'rekam_medis';

    public function pasien()
	{
		return $this->belongsTo('App\Pasien', 'id_pasien', 'id');
	}

	public function tenaga_medis()
	{
		return $this->hasOne('App\TenagaMedis', 'no_pegawai' , 'np_dokter');
	}
}