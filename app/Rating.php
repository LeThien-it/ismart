<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;


class Rating extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public $statusRatting = [
        0 => [
            'name' => 'Chưa duyệt',
            'class' => 'badge badge-secondary',
        ],
        1 => [
            'name' =>  'Đã duyệt',
            'class' => 'badge badge-primary',
        ],

    ];

    function getStatus()
    {
        return Arr::get($this->statusRatting, $this->status);
    }
    
    function customer(){
        return $this->belongsTo('App\Customer','customer_id')->withTrashed();
    }

    function product(){
        return $this->belongsTo('App\Product','product_id')->withTrashed();
    }
}
