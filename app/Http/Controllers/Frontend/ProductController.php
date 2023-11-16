<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\DB;
use App\CategoryProduct;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductVariant;
use App\Rating;
use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    function category(Request $request)
    {
        //show slider-banner
        $banner_mains = Slider::where('box', 0)->get();
        $banner_subs = Slider::where('box', 1)->get();
        $banner = [$banner_mains, $banner_subs];
        //get brand
        $brand = CategoryProduct::where('slug', $request->slug)->first();
        // dd($brand);
        $brandParent = '';
        if ($brand->parent_id == 0) {
            $brandFilter = $brand;
        } else {
            $brandFilter = $brand->parentCategory;
        }
        $priceArray = [];

        $priceFilter = [
            '2t' => [0, 2000000],
            '2-4t' => [2000000, 4000000],
            '4-7t' => [4000000, 7000000],
            '7-13t' => [7000000, 13000000],
            '13t' => [13000000, 1000000000],
        ];

        $sort = !empty($request->sort) ? $request->sort : 'latest';

        if ($request->r_price || $request->r_brand) {
            $price = $request->r_price;
            $brand_request = $request->r_brand;

            if ($brand_request) {
                $brand_get = CategoryProduct::whereIn(
                    'id',
                    $brand_request
                )->get();
                foreach ($brand_get as $item) {
                    $catId[] = $item->id;
                    if ($item->childrenCategorys->count() > 0) {
                        foreach ($item->childrenCategorys as $v) {
                            $catId[] = $v->id;
                        }
                    }
                }
            } else {
                if ($brand->childrenCategorys->count() > 0) {
                    foreach ($brand->childrenCategorys as $item) {
                        $catId[] = $item->id;
                        if ($item->childrenCategorys) {
                            foreach ($item->childrenCategorys as $item1) {
                                $catId[] = $item1->id;
                            }
                        }
                    }
                } else {
                    $catId[] = $brand->id;
                }
            }

            if ($price) {
                foreach ($priceFilter as $key => $value) {
                    if ($key == $price) {
                        $priceArray[] = $value;
                    }
                }
                $products = getProductFilterArray($priceArray, $sort, $catId);
                // dd($priceArray);
            } else {
                $products = getProductFilter($sort, $catId);
            }
        } elseif ($request->slug) {
            if ($brand->childrenCategorys->count() > 0) {
                foreach ($brand->childrenCategorys as $item) {
                    $catId[] = $item->id;
                    if ($item->childrenCategorys->count() > 0) {
                        foreach ($item->childrenCategorys as $v) {
                            $catId[] = $v->id;
                        }
                    }
                }
                $products = getProductFilter($sort, $catId);
            } else {
                $products = getProductFilter($sort, [$brand->id]);
            }
        }
        return view(
            'frontend.product.category-product',
            compact('banner', 'products', 'brand', 'brandFilter')
        );
    }

    function detail(Request $request)
    {
        $product = Product::where('slug', $request->productSlug)->first();
        $pro_cat_id = $product->category_product_id;
        $colors = [];
        $memorys = [];
        $productSlugs = [];
        $arr = [];

        if ($request->code) {
            $id = $request->code;
            $product_id = ProductVariant::find($id)->product->id;
        }
        $allProductCat = Product::where(
            'category_product_id',
            $pro_cat_id
        )->get();

        foreach ($allProductCat as $pro) {
            foreach ($pro->variants as $item) {
                if ($item->attributeValues) {
                    foreach ($item->attributeValues as $i2) {
                        if (strtolower($i2->attribute->name) == 'bộ nhớ') {
                            $arr[$item->id]['memory'] = $i2->value;
                        }
                        if (strtolower($i2->attribute->name) == 'màu sắc') {
                            $arr[$item->id]['color'] = $i2->value;
                        }
                        $arr[$item->id]['code'] = $item->id;
                        $arr[$item->id]['productSlug'] = $pro->slug;
                    }
                }
            }
        }
        // dd($arr);
        foreach ($arr as $k => $v) {
            if (array_key_exists('memory', $v)) {
                $memorys[$k] = $v['memory'];
            }
            $productSlugs[$k] = $v['productSlug'];
        }
        $memorys = array_unique($memorys);
        // dd($memorys);

        $productSlugs = array_unique($productSlugs);
        // dd($productSlugs);

        /*--------------------------*/

        //review star
        $ratings = Rating::where([
            ['product_id', '=', $product_id],
            ['status', 1],
        ])
            ->with('customer:id,name')
            ->orderByDesc('id')
            ->paginate(4);

        if ($request->ajax()) {
            $html = view(
                'frontend.include.include_list_rating',
                compact('ratings')
            )->render();
            return response(['html' => $html]);
        }

        $ratingDashboards = Rating::where([
            ['product_id', '=', $product_id],
            ['status', 1],
        ])
            ->select(DB::raw('count(num_star) as rating_count'))
            ->addSelect('num_star')
            ->groupBy('num_star')
            ->get()
            ->toArray();

        $rating_total = 0;
        $ratingDefault = $this->mapRatingDefault();

        foreach ($ratingDashboards as $item) {
            $rating_total += $item['rating_count'];
            $ratingDefault[$item['num_star']] = $item;
        }
        $totalOfNumStar = 0;
        foreach ($ratingDefault as $item) {
            $totalOfNumStar += $item['num_star'] * $item['rating_count'];
        }
        if ($rating_total != 0) {
            $avgStar = round($totalOfNumStar / $rating_total, 0);
        } else {
            $avgStar = 0;
        }

        //same product
        $cat = CategoryProduct::where('slug', $request->slug)->first();

        foreach ($cat->childrenCategorys as $catItem) {
            $catIds[] = $catItem->id;
            if ($catItem->childrenCategorys) {
                foreach ($catItem->childrenCategorys as $catItemChildren) {
                    $catIds[] = $catItemChildren->id;
                }
            }
        }

        $sameCats = Product::whereIn('category_product_id', $catIds)
            ->join('product_variants', function ($join) use ($request) {
                $join
                    ->on('products.id', '=', 'product_variants.product_id')
                    ->where([
                        ['product_variants.display_style', '=', 1],
                        ['product_variants.id', '!=', $request->code],
                    ]);
            })
            ->select(
                'products.id',
                'products.slug',
                'products.name',
                'product_variants.id as variant_id',
                'product_variants.price',
                'product_variants.price_old',
                'product_variants.feature_image_path',
                'product_variants.id as variant_id'
            )
            ->get();
        // dd($sameCat);
        // dd($product);
        return view(
            'frontend.product.detail-product',
            compact(
                'product',
                'memorys',
                'arr',
                'productSlugs',
                'ratings',
                'ratingDefault',
                'rating_total',
                'avgStar',
                'sameCats',
                'cat'
            )
        );
    }

    //Hàm mapRatingDefault để gán giá trị mặc định cho thanh progress bar star , để khi đánh giá bằng 0 thì vẫn hiển thị cho người dùng biết
    private function mapRatingDefault()
    {
        $ratingDefault = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDefault[$i] = [
                'rating_count' => 0,
                'num_star' => $i,
            ];
        }
        return $ratingDefault;
    }

    function search(Request $request)
    {
        $sort = !empty($request->sort) ? $request->sort : 'latest';
        $ids = [];
        $products = Product::where(
            'name',
            'LIKE',
            '%' . $request->key . '%'
        )->get();
        foreach ($products as $product) {
            $ids[] = $product->categoryProduct->ultimateParent()->id;
        }
        $ids = array_values(array_unique($ids));
        $product_arr = [];
        $brands = CategoryProduct::whereIn('id', $ids)->get();
        $products = ProductVariant::select(
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
            ->join('products', function ($join) use ($request) {
                $join
                    ->on('product_variants.product_id', '=', 'products.id')
                    ->where('name', 'like', '%' . $request->key . '%');
            })
            ->where(function ($q) {
                $q->where('display_style', '=', 1)->Where('show_search', 1);
            })
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
            ->get();

        $priceFilter = [
            '2t' => [0, 2000000],
            '2-4t' => [2000000, 4000000],
            '4-7t' => [4000000, 7000000],
            '7-13t' => [7000000, 13000000],
            '13t' => [13000000, 10000000000],
        ];

        if ($request->r_price || $request->r_brand) {
            $price = $request->r_price;
            $brand_request = $request->r_brand;

            if ($brand_request) {
                $brand_get = CategoryProduct::whereIn(
                    'id',
                    $brand_request
                )->get();
                // dd($brand_get);
            } else {
                $brand_get = $brands;
            }
            foreach ($brand_get as $item) {
                $catIds[] = $item->id;
            }
            if ($price) {
                foreach ($priceFilter as $key => $value) {
                    if ($key == $price) {
                        $priceArray = $value;
                    }
                }
                $products = $products->whereBetween('price', $priceArray);
            } else {
                $products = $products;
            }
            $products = $products->filter(function ($item) use ($catIds) {
                $catPro = CategoryProduct::find($item->category_product_id);
                $grandParent = $catPro->ultimateParent()->id;
                return in_array($grandParent, $catIds);
            });
        }
        $perPage = 8;

        // Số trang hiện tại (nếu bạn cần)
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // Tạo một LengthAwarePaginator từ Collection
        $products = new LengthAwarePaginator(
            $products->forPage($currentPage, $perPage), // Dữ liệu trên trang hiện tại
            $products->count(), // Tổng số bản ghi
            $perPage, // Số lượng bản ghi trên mỗi trang
            $currentPage, // Trang hiện tại
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        return view('frontend.product.search', compact('brands', 'products'));
    }

    function suggestions(Request $request)
    {
        $products = ProductVariant::select(
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
            ->join('products', function ($join) use ($request) {
                $join
                    ->on('product_variants.product_id', '=', 'products.id')
                    ->where('name', 'like', '%' . $request->key . '%');
            })
            ->where(function ($q) {
                $q->where('display_style', '=', 1)->Where('show_search', 1);
            })
            ->latest()
            ->paginate(5);

        $txt = '<ul class="suggest_search">';
        if (count($products) > 0) {
            $txt .=
                '<li class="title"><div class="viewed">Có phải bạn muốn tìm</div></li>';
        }
        foreach ($products as $item) {
            $src_img = asset("{$item->feature_image_path}");
            $hrefProduct = route('frontend.product.detail', [
                'slug' => getSlugByCatId($item->category_product_id),
                'productSlug' => $item->slug,
                'code' => $item->variant_id,
            ]);
            $txt .=
                '<li class="product_suggest">
                        <a href="' .
                $hrefProduct .
                '">
                            <div class="item-img">
                                <img src="' .
                $src_img .
                '" alt="" class="img-fluid">
                            </div>
                            <div class="item-info">
                                <h3>' .
                $item->name .
                '</h3>
                                <strong class="price">' .
                number_format($item->price, 0, ',', '.') .
                '₫</strong>
                            </div>
                        </a>
                    </li>';
        }
        $txt .= '</ul>';

        return json_encode([
            'code' => 200,
            'text' => $txt,
            'message' => 'Success',
        ]);
    }
}
