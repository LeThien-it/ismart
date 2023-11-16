<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id')->withTrashed();
    }
    function orderDetails()
    {
        return $this->hasMany('App\OrderDetail', 'order_id');
    }

    protected $statusOrder = [
        1 => [
            'name' => 'Đang xử lý',
            'class' => 'badge badge-warning',
        ],
        2 => [
            'name' =>  'Đang giao hàng',
            'class' => 'badge badge-primary',
        ],
        3 => [
            'name' =>  'Hoàn thành',
            'class' => 'badge badge-success',
        ],
        4 => [
            'name' =>  'Hủy đơn hàng',
            'class' => 'badge badge-danger',
        ],

    ];

    function getStatus()
    {
        return Arr::get($this->statusOrder, $this->status);
    }
}
