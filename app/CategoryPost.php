<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryPost extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','slug','parent_id','user_id','position'];
    
    public function parentCategory(){
        return $this->belongsTo('App\CategoryPost','parent_id');
    }

    public function user(){
        return $this->belongsTo("App\User","user_id");
    }

    public function childrenCategorys(){
        return $this->hasMany("App\CategoryPost","parent_id");
    }

    function getNameFromParentId(){
        $catPost = CategoryPost::onlyTrashed()->find($this->parent_id);
        return $catPost;
    }

    function posts(){
        return $this->hasMany('App\Post','category_id');
    }
    
}
