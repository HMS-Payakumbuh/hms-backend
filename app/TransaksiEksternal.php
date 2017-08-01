<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiEksternal extends Model
{
    protected $table = 'transaksi_eksternal';

    protected $fillable = ['harga_total', 'status'];

    public function obatTebus()
	{
		return $this->hasMany('App\ObatTebus', 'id_transaksi_eksternal');
	}

	public function obatEceran()
	{
		return $this->hasMany('App\ObatEceran', 'id_transaksi');
	}
}
