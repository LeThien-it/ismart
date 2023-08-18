<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    
    function images(){
        return $this->hasMany('App\ProductImage','product_variant_id')->withTrashed();
    }
    
    function attributeValues(){
        return $this->belongsToMany('App\AttributeValue','product_variant_attribute_value','product_variant_id','attribute_value_id')->withTimestamps();
    }

    function product()
    {
        return $this->belongsTo('App\Product','product_id')->withTrashed();
    }
    
}
