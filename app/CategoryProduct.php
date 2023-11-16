<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryProduct extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'parent_id', 'user_id','class_icon','position'];

    public function parentCategory()
    {
        return $this->belongsTo("App\CategoryProduct", "parent_id");
    }

    public function ultimateParent() {
        if ($this->parentCategory) {
            return $this->parentCategory->ultimateParent();
        }

        return $this;
    }
    
    public function user()
    {
        return $this->belongsTo("App\User", "user_id");
    }

    public function childrenCategorys()
    {
        return $this->hasMany("App\CategoryProduct", "parent_id");
    }

    public function products(){
        return $this->hasMany("App\Product","category_product_id");
    }

    
    function getNameFromParentId(){
        $catProduct = $this->onlyTrashed()->find($this->parent_id);
        return $catProduct;
    }
}
