<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    function permissionParent()
    {
        return $this->belongsTo('App\Permission','parent_id');
    }
    
    function permissionChildrens()
    {
        return $this->hasMany('App\Permission','parent_id');
    }
}
