<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'content',
        'warranty',
        'promotion',
        'parameter',
        'parameter_detail',
        'category_product_id',
        'user_id',
        'slug',
        'status',
        'featured'

    ];

    protected $statusProduct = [
        0 => [
            'name' => 'Chờ duyệt',
            'class' => 'badge badge-secondary',
        ],
        1 => [
            'name' =>  'Công khai',
            'class' => 'badge badge-primary',
        ],

    ];

    function getStatus()
    {
        return Arr::get($this->statusProduct, $this->status);
    }
    
    function user()
    {
        return $this->belongsTo('App\User', 'user_id')->withTrashed();
    }

    function categoryProduct()
    {
        return $this->belongsTo('App\CategoryProduct', 'category_product_id')->withTrashed();
    }

    function variants()
    {
        return $this->hasMany('App\ProductVariant', 'product_id')->withTrashed();
    }
    
    function ratings(){
        return $this->hasMany('App\Rating','product_id')->withTrashed();
    }
}
