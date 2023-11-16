<?php

use App\CategoryPost;
use App\CategoryProduct;
use App\Product;
use App\ProductVariant;
use App\Rating;

function getId($model, $id)
{
    return $model::find($id);
}

function getSlug($slug)
{
    return CategoryProduct::where('slug', $slug)->first();
}

function getSlugByCatId($catId)
{
    $cat = CategoryProduct::find($catId);
    if ($cat->parentCategory->parent_id == 0) {
        $slug = $cat->parentCategory->slug;
    } else {
        $slug = $cat->parentCategory->parentCategory->slug;
    }
    return $slug;
}

function checkParentCategory($catId)
{
    $catPro = CategoryProduct::find($catId);
    if ($catPro->parentCategory->parent_id != 0) {
        return $catPro = $catPro->parentCategory;
    } else {
        return $catPro;
    }
}

function getProductFilter($sort, $catId)
{
    $product_filter = DB::table('products')
        ->join('product_variants', function ($join) {
            $join
                ->on('products.id', '=', 'product_variants.product_id')
                ->whereNull('product_variants.deleted_at');
        })
        ->join(
            'category_products',
            'products.category_product_id',
            '=',
            'category_products.id'
        )
        ->select(
            'products.id',
            'products.name',
            'products.slug',
            'products.category_product_id',
            'products.status',
            'product_variants.id AS variant_id',
            'product_variants.feature_image_path',
            'product_variants.price',
            'product_variants.price_old',
            'product_variants.quantity',
            'product_variants.created_at'
        )
        ->whereIn('category_product_id', $catId)
        ->where([['status', '=', '1'], ['display_style', '=', '1']])
        ->whereNull('products.deleted_at')
        ->when($sort, function ($query, $sort) {
            $query
                ->when('high-to-low' == $sort, function ($query) {
                    $query->orderBy('price', 'desc');
                })
                ->when('low-to-high' == $sort, function ($query) {
                    $query->orderBy('price', 'asc');
                })
                ->when('latest' == $sort, function ($query) {
                    $query->latest();
                })
                ->when('featured' == $sort, function ($query) {
                    $query->where('featured', 1);
                });
        })
        ->paginate(8);

    return $product_filter;
}

function getProductFilterArray($priceArray, $sort, $catId)
{
    $product_filter = DB::table('products')
        ->join('product_variants', function ($join) {
            $join
                ->on('products.id', '=', 'product_variants.product_id')
                ->whereNull('product_variants.deleted_at');
        })
        ->join(
            'category_products',
            'products.category_product_id',
            '=',
            'category_products.id'
        )
        ->select(
            'products.id',
            'products.name',
            'products.slug',
            'products.category_product_id',
            'products.status',
            'product_variants.id AS variant_id',
            'product_variants.feature_image_path',
            'product_variants.price',
            'product_variants.price_old',
            'product_variants.quantity',
            'product_variants.created_at'
        )
        ->whereIn('category_product_id', $catId)
        ->whereBetween('price', $priceArray)
        ->where([['status', '=', '1'], ['display_style', '=', '1']])
        ->whereNull('products.deleted_at')
        ->when($sort, function ($query, $sort) {
            $query
                ->when('high-to-low' == $sort, function ($query) {
                    $query->orderBy('price', 'desc');
                })
                ->when('low-to-high' == $sort, function ($query) {
                    $query->orderBy('price', 'asc');
                })
                ->when('latest' == $sort, function ($query) {
                    $query->latest();
                })
                ->when('featured' == $sort, function ($query) {
                    $query->where('featured', 1);
                });
        })
        ->paginate(8);

    return $product_filter;
}

function getImage($id)
{
    $variant = ProductVariant::find($id);
    $image = $variant->feature_image_path;
    return $image;
}

function getStringFirst($str)
{
    $words = explode(' ', mb_convert_case($str, MB_CASE_TITLE));

    $result = ' ';

    foreach ($words as $w) {
        $result .= mb_substr($w, 0, 1);
    }
    return $result;
}

// Hàm lấy tổng đánh giá và trung bình sao
function getRatingStar($product_id)
{
    $ratingFilter = Rating::where([
        ['product_id', '=', $product_id],
        ['status', '=', 1],
    ])
        ->select(DB::raw('count(num_star) as rating_count'))
        ->addSelect('num_star')
        ->groupBy('num_star')
        ->get()
        ->toArray();

    $rating_total = 0;
    $total_rating_of_all_stars = 0;
    foreach ($ratingFilter as $item) {
        $rating_total += $item['rating_count'];
        $total_rating_of_all_stars += $item['num_star'] * $item['rating_count'];
    }

    $avgStar = round($total_rating_of_all_stars / $rating_total);
    $ratingStar = [$avgStar, $rating_total];
    return $ratingStar;
}

// hàm kiểm tra có đánh giá chưa
function checkRating($product_id)
{
    $product = DB::table('products')
        ->join('ratings', function ($join) {
            $join
                ->on('products.id', '=', 'ratings.product_id')
                ->where('ratings.status', '=', 1);
        })
        ->where('product_id', $product_id)
        ->get();
    // dd($product);
    if (count($product) > 0) {
        return true;
    }
    return false;
}

//Hàm show sản phẩm theo slug:
function showProductHome($slug)
{
    $catIds = [];
    $cat = CategoryProduct::where('slug', $slug)->first();
    foreach ($cat->childrenCategorys as $a) {
        $catIds[] = $a->id;
        foreach ($a->childrenCategorys as $v) {
            $catIds[] = $v->id;
        }
    }
    $product = Product::where('featured', 1)
    ->join('product_variants', function ($join) use (
        $catIds
    ) {
        $join
            ->on('products.id', '=', 'product_variants.product_id')
            ->where('display_style', 1)
            ->whereIn('category_product_id', $catIds)
            ->whereNull('product_variants.deleted_at');
    })
        ->select(
            'products.id',
            'products.name',
            'products.slug',
            'product_variants.price',
            'product_variants.price_old',
            'product_variants.feature_image_path',
            'product_variants.id as variant_id'
        )
        ->inRandomOrder()
        ->get();
    $product = [$cat, $product];
    return $product;
}

function form_check_price($value, $label)
{
    $html = '';
    $html .= '<div class="form-check">';
    $html .=
        '<input class="form-check-input" type="radio" name="r_price" id="' .
        $value .
        '" value="' .
        $value .
        '"';

    if (request()->r_price) {
        $html .= request()->r_price == $value ? 'checked >' : '>';
    } else {
        $html .= '>';
    }
    $html .= '<label class="form-check-label" for="' . $value . '">';
    $html .= $label;
    $html .= '</label>';
    $html .= '</div>';

    return $html;
}

// form filter frontend

function form_filter($option, $text)
{
    $html = '';
    $html .=
        '<option
    value="' .
        $option .
        '"';
    $html .= request()->sort == $option ? 'selected >' : '>';
    $html .= $text;
    $html .= '</option>';

    return $html;
}


