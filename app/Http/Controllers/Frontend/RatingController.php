<?php

namespace App\Http\Controllers\Frontend;

use App\Customer;
use App\Http\Controllers\Controller;
use App\ProductVariant;
use App\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{

    function addRating(Request $request,$id){
        
        $variant = ProductVariant::find($id);
        $product_id = $variant->product->id;
        
        $customer = Customer::firstOrCreate([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $customer->ratings()->create([
            'product_id' => $product_id,
            'num_star' => $request->num_star,
            'content' => $request->content
        ]);
        
        // \Log::info($a);
       
        return response()->json(['code'=>200,'variant' => $variant]);
    }
}
