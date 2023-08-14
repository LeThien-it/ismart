<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;


class Post extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'content',
        'slug',
        'post_image_name',
        'post_image_path',
        'user_id',
        'category_id',
        'status',
        'desc'
    ];

    protected $statusPost = [
        0 => [
            'name' => 'Chờ duyệt',
            'class' => 'badge badge-secondary'
        ],
        1 => [
            'name' => 'Công khai',
            'class' => 'badge badge-primary'
        ],
    ];

    function getStatus()
    {
        return Arr::get($this->statusPost, $this->status);
    }

    function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    function categoryPost()
    {
        return $this->belongsTo('App\CategoryPost', 'category_id');
    }

    
}
