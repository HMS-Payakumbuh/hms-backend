<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiEksternal extends Model
{
    protected $table = 'transaksi_eksternal';

    protected $fillable = ['harga_total', 'status'];
}
