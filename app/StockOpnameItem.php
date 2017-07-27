<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockOpnameItem extends Model
{
    protected $table = 'stock_opname_item';

    /**
    *	Get the JenisObat of the StockOpnameItem.
    */
    public function jenisObat()
    {
        return $this->belongsTo('App\JenisObat', 'id_jenis_obat');
    }

    /**
    *	Get the StokObat of the StockOpnameItem.
    */
    public function stokObat()
    {
        return $this->belongsTo('App\StokObat', 'id_stok_obat');
    }
}
