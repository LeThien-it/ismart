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
            $posts = Post::where([['status', 1], ['category_id', $catPost->id]])
                ->latest()
                ->paginate(5);
        } else {
            session(['url' => true]);
            $active = 'badge badge-warning';
            $posts = Post::where('status', 1)
                ->latest()
                ->limit(8)
                ->paginate(4);
        }
               
        $bestSellingProducts = ProductVariant::orderBy('sales_count', 'desc')->take(5)->get();
        return view(
            'frontend.post.show',
            compact('catPostLinks', 'posts', 'active', 'bestSellingProducts')
        );
    }

    function detail(Request $request)
    {
        Carbon::setLocale('vi');
        $post = Post::where('slug', $request->slugPost)->first();

        return view('frontend.post.detail', compact('post'));
    }
}
