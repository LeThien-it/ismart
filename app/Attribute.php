<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;


class Attribute extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'user_id',
        'status'
    ];

    public $statusAttribute = [
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
        return Arr::get($this->statusAttribute, $this->status);
    }
    
    function user(){
        return $this->belongsTo('App\User','user_id');
    }

    function values(){
        return $this->hasMany('App\AttributeValue','attribute_id');
    }

    
}
