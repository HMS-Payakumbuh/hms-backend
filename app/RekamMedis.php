<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $table = 'rekam_medis';

    public function pasien()
	{
		return $this->belongsTo('App\Pasien', 'id_pasien');
	}

	public function tenaga_medis()
	{
		return $this->hasOne('App\TenagaMedis', 'no_pegawai' , 'np_dokter');
	}

	public function diagnosis()
	{
		return $this->hasMany('App\Diagnosis', 'tanggal_waktu', 'tanggal_waktu');
	}
}