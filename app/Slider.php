<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;


class Slider extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'image_path',
        'image_name',
        'user_id',
        'status',
        'position',
        'box',
        'cat_pro_id',
        'title'
    ];

    public $statusSlider = [
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
        return Arr::get($this->statusSlider, $this->status);
    }
    function user(){
        return $this->belongsTo('App\User','user_id');
    }

    function categoryProduct()
    {
        return $this->belongsTo('App\CategoryProduct','cat_pro_id');
    }
}
