<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
class Page extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'content',
        'slug',
        'user_id',
        'status'
    ];

    protected $statusPage = [
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
        return Arr::get($this->statusPage, $this->status);
    }

    function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
