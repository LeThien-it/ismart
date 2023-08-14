<?php

namespace App\Http\Controllers\Frontend;

use App\CategoryPost;
use App\Http\Controllers\Controller;
use App\Order;
use App\Post;
use App\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    function show(Request $request)
    {
        Carbon::setLocale('vi');
        $catPostLinks = CategoryPost::all();
        $active = '';
        if ($request->slug) {
            $request->session()->forget('url');
            $catPost = CategoryPost::where('slug', $request->slug)->first();
            $posts = Post::where([
                ['status', 1],
                ['category_id', $catPost->id],
            ])->latest()->paginate(5);
        } else {
            session(['url' => true]);
            $active = 'badge badge-warning';
            $posts = Post::where('status', 1)->latest()->limit(8)->paginate(4);
        }

        $salefilter = DB::table('order_details')
            ->select([
                'product_variants.id',
                // 'product_variants.product_id',
                DB::raw('SUM(order_details.qty) as total_qty'),
            ])
            ->join('product_variants', 'order_details.product_variant_id', '=', 'product_variants.id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status',3)
            ->groupBy('product_variants.id')
            ->orderByDesc('total_qty')
            ->get();
        foreach($salefilter as $item){
            $idsFilter[] = $item->id;
        }
        $ids = implode(',', $idsFilter);
        $sales = ProductVariant::whereIn('id',$idsFilter)->orderByRaw("FIELD(id, $ids)")->take(5)->get();
        // dd($sales);

        return view('frontend.post.show', compact('catPostLinks', 'posts', 'active','sales'));
    }

    function detail(Request $request)
    {
        Carbon::setLocale('vi');
        $post = Post::where('slug', $request->slugPost)->first();

        return view('frontend.post.detail', compact('post'));
    }
}
