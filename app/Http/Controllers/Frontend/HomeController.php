<?php

namespace App\Http\Controllers\Frontend;

use App\CategoryProduct;
use App\Http\Controllers\Controller;
use App\Page;
use App\Product;
use App\ProductVariant;
use App\Rating;
use App\Slider;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    function index()
    {
        $sliders = Slider::where([['cat_pro_id', 0], ['box', 0], ['status', 1]])
            ->orderBy('position', 'asc')
            ->get();
        $banner_subs = Slider::where([
            ['cat_pro_id', 0],
            ['box', 1],
            ['status', 1],
        ])
            ->orderBy('position', 'asc')
            ->limit(2)
            ->get();
        $catProductParent = CategoryProduct::where('parent_id',0)->get();
        return view(
            'frontend.home.index',
            compact(
                'sliders',
                'banner_subs',
                'catProductParent',
            )
        );
    }

}
