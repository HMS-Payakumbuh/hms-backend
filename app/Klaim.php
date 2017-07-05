<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Klaim extends Model
{
    protected $table = 'klaim';

    public function pembayaran()
	{
		return $this->hasOne('App\Pembayaran', 'id_pembayaran');
	}
}
