<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','desc','user_id'];
    
    function permissions(){
        return $this->belongsToMany('App\Permission','permission_role','role_id','permission_id');
    }
    function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
