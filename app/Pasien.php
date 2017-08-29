<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Carbon\Carbon; 

class Pasien extends Eloquent
{
    protected $table = 'pasien';
    
    public function age() {
    	if ($this->tanggal_lahir) {
	    	$date = Carbon::parse($this->tanggal_lahir);
	    	return $date->diffInYears(Carbon::now());
	    } else {
	    	return null;
	    }
	}

	public function asuransi()
	{
		return $this->hasMany('App\Asuransi', 'id_pasien');
	}

	public function catatan_kematian()
	{
		return $this->hasOne('App\CatatanKematian', 'id_pasien');
	}
}

