<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    protected $guarded = [];
    function variant(){
        return $this->belongsTo('App\ProductVariant','product_variant_id');
    }
    function order(){
        return $this->belongsTo('App\Order','order_id');
    }
}
