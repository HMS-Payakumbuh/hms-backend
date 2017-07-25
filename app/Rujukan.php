<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rujukan extends Model
{
	protected $table = 'rujukan';

	public function transaksi()
	{
		return $this->belongsTo('App\Transaksi', 'id_transaksi');
	}
}
