<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','email','phone','address'];

    function ratings(){
        return $this->hasMany('App\Rating','customer_id');
    }
    
    function orders(){
        return $this->hasMany('App\Order','customer_id')->withTrashed();
    }
}
