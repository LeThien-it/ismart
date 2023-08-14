<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PageController extends Controller
{
    function detail(Request $request){
        Carbon::setLocale('vi');
        $pageDetail = Page::where([['status',1],['slug',$request->slug]])->select('name','content','slug','created_at')->first();
        // dd($pageDetail);
        return view('frontend.page.detail',compact('pageDetail'));
    }
}
