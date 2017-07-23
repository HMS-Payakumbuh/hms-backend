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

	public function obatTebusItem()
	{
		return $this->hasMany('App\ObatTebusItem', 'id_pembayaran');
	}

	public function obatEceranItem()
	{
		return $this->hasMany('App\ObatEceranItem', 'id_pembayaran');
	}

	public function pemakaianKamarRawatInap()
	{
		return $this->hasMany('App\PemakaianKamarRawatInap', 'id_transaksi');
	}
}
