<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    protected $table = 'stock_opname';

    /**
    *	Get the StockOpnameItem of the StockOpname
    */
    public function stockOpnameItem()
    {
    	return $this->hasMany('App\StockOpnameItem', 'id_stock_opname');
    }
}
