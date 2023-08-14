<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeValue extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'attribute_id',
        'value',
    ];

    function attribute(){
        return $this->belongsTo('App\Attribute','attribute_id');
    }

}
