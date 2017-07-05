<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    public function transaksi()
	{
		return $this->belongsTo('App\Transaksi', 'id_transaksi');
	}

	public function klaim()
	{
		return $this->hasOne('App\Klaim', 'id_pembayaran');
	}

	public function tindakan()
	{
		return $this->hasMany('App\Tindakan', 'id_pembayaran');
	}

	public function obat()
	{
		return $this->hasMany('App\ObatTebus', 'id_pembayaran');
	}
}
