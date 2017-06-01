<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Carbon\Carbon; 

class Pasien extends Eloquent
{
    protected $table = 'pasien';
    public function age() {
    	$date = Carbon::parse($this->tanggal_lahir);
    	return $date->diffInYears(Carbon::now());
	}
}

