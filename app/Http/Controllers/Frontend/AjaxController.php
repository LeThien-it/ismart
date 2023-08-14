<?php

namespace App\Http\Controllers\Frontend;

use App\CategoryProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\ProductVariant;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    protected $html = '';

    function ajaxImage(Request $request)
    {
        $id = $request->id;
        $images = ProductVariant::find($id)->images;
        $this->html .= '<div id="sync-big" class="slider-big owl-carousel owl-theme">';
        foreach ($images as $image) {
            $this->html .= ' <div class="item">';
            $this->html .= '<img src="' . asset($image->image_path) . '" alt="OPPO A95" />';
            $this->html .= '</div>';
        }
        $this->html .= '</div>';

        $this->html .= '<div id="sync-small" class="slider-small owl-carousel owl-theme">';
        foreach ($images as $image) {
            $this->html .= ' <div class="item">';
            $this->html .= '<img src="' . asset($image->image_path) . '" alt="OPPO A95" />';
            $this->html .= '</div>';
        }
        $this->html .= '</div>';
        

        return response()->json(['code' => 200, 'id' => $id, 'html' => $this->html]);
    }
}
