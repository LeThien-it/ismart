<?php

namespace App\Http\View\Composers;

use App\CategoryProduct;
use App\Page;
use Illuminate\View\View;

class HeaderComposer
{
    protected $catProducts;
    public function __construct(CategoryProduct $catProducts)
    {
        $this->catProducts = $catProducts;
    }

    public function compose(View $view)
    {
        $catProducts = $this->catProducts->where('parent_id', 0)->orderBy('position', 'asc')->get();
        $pages = Page::where('status', 1)->select('name', 'slug')->get();

        $view->with('catProducts', $catProducts);
        $view->with('pages', $pages);
    }
}
