<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public function product_type(){
    	$this->belongsTo('App\ProductType', 'id_type', 'id');
    }

    public function bill_detail(){
    	return $this->hasMany('App\Bill_detail', 'id_product', 'id');
    }
}
