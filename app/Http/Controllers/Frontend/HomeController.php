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
        $sliders = Slider::where([
            ['cat_pro_id', 0],
            ['box', 0],
            ['status', 1]
        ])->orderBy('position', 'asc')->get();
        $banner_subs = Slider::where([
            ['cat_pro_id', 0],
            ['box', 1],
            ['status', 1]
        ])->orderBy('position', 'asc')->limit(2)->get();
        
        $catIds = [];
        $catPhone = CategoryProduct::where('slug','dien-thoai')->first();
        foreach($catPhone->childrenCategorys as $a){
            $catIds[] = $a->id; 
            foreach($a->childrenCategorys as $v){
               $catIds[] = $v->id;
            }
        }
        $phone_features = Product::where('featured', 1)->join('product_variants', function ($join) use ($catIds) {
            $join->on('products.id', '=', 'product_variants.product_id')->where('display_style', 1)->whereIn('category_product_id',$catIds)->whereNull('product_variants.deleted_at');
        })->select(
            'products.id',
            'products.name',
            'products.slug',
            'product_variants.price',
            'product_variants.price_old',
            'product_variants.feature_image_path',
            'product_variants.id as variant_id',
        )->get();
        $tablets = showProductHome('may-tinh-bang');
        $laptops = showProductHome('laptop');
        
        return view('frontend.home.index', compact('sliders', 'banner_subs', 'phone_features','tablets','laptops','catPhone'));
    }
}
