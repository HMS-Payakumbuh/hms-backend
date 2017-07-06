<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Klaim extends Model
{
    protected $table = 'klaim';

    public function pembayaran()
	{
		return $this->hasOne('App\Pembayaran', 'id', 'id_pembayaran');
	}

	public function asuransi()
	{
		return $this->hasOne('App\Asuransi', 'id', 'id_asuransi');
	}
}
