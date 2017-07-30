<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $table = 'antrian';
    protected $primaryKey = 'no_antrian';
    const CREATED_AT = 'waktu_masuk_antrian';
    const UPDATED_AT = 'waktu_perubahan_antrian';

    public function transaksi()
	{
		return $this->belongsTo('App\Transaksi', 'id_transaksi');
	}
}