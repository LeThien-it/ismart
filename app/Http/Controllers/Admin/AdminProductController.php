<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\CategoryProduct;
use App\Components\Recursive;
use App\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class AdminProductController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }

    function list(Request $request)
    {
        $kind = $request->kind;
        $count_active = Product::count();
        $count_trash = Product::onlyTrashed()->count();
        $count_pending = Product::where('status', 0)->count();
        $count_public = Product::where('status', 1)->count();
        $count_featured = Product::where('featured', 1)->count();

        $count = [$count_active, $count_trash, $count_pending, $count_public, $count_featured];
        $list_field = [
            'id' => 'ID',
            'name' => 'Tên sản phẩm',
        ];

        if ($kind == 'trash') {
            $products = Product::onlyTrashed()->latest()->paginate(8);
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
        } else {
            $products = Product::latest()->paginate(8);
            $list_act = [
                'delete' => 'Xóa tạm thời'
            ];
            if ($kind == 'pending') {
                $products = Product::where('status', 0)->latest()->paginate(8);
            }
            if ($kind == 'public') {
                $products = Product::where('status', 1)->latest()->paginate(8);
            }
            if ($kind == 'featured') {
                $variants = Product::where('featured', 1)->latest()->paginate(8);
            }

            $field = $request->field;
            $keyword = $request->input('keyword');
            if ($keyword) {
                $products = Product::where($field, 'like', '%' . $keyword . '%')->paginate(8);
            }
            $keyword1 = $request->input('keyword1');

            if ($keyword1) {
                $products = Product::where($field, 'like', '%' . $keyword1 . '%')->onlyTrashed()->paginate(8);
                $list_act = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                return view('admin.products.list-trash', compact('products', 'list_field', 'list_act', 'count'));
            }
        }
        return view('admin.products.list', compact('products', 'list_field', 'list_act', 'count'));
    }

    function getCategory($parentId)
    {
        $data = CategoryProduct::all();
        $recursive = new Recursive();
        $htmlOption = $recursive->itemRecursive($parentId, 0, '', $data);
        return $htmlOption;
    }

    function add()
    {
        $htmlOption = $this->getCategory('');
        return view('admin.products.add.add', compact('htmlOption'));
    }

    function store(ProductRequest $request)
    {
        Product::create([
            'name' => $request->name,
            'content' => $request->content,
            'warranty' => $request->warranty,
            'promotion' => $request->promotion,
            'parameter' => $request->parameter,
            'parameter_detail' => $request->parameter_detail,
            'category_product_id' => $request->category_product_id,
            'user_id' => Auth::id(),
            'slug' => Str::slug($request->name, '-'),
            'status' => $request->status,
            'featured' => $request->featured ? $request->featured : 0,
        ]);

        return redirect()->route('product.list')->with('status', 'thêm bài viết thành công');
    }

    function edit($id)
    {
        $product = Product::find($id);
        $htmlOption = $this->getCategory('');
        return view('admin.products.edit', compact('product', 'htmlOption'));
    }

    function update(ProductRequest $request, $id)
    {
        Product::find($id)->update([
            'name' => $request->name,
            'content' => $request->content,
            'warranty' => $request->warranty,
            'promotion' => $request->promotion,
            'parameter' => $request->parameter,
            'parameter_detail' => $request->parameter_detail,
            'category_product_id' => $request->category_product_id,
            'user_id' => Auth::id(),
            'slug' => Str::slug($request->name, '-'),
            'status' => $request->status,
            'featured' => $request->featured ? $request->featured : 0,
        ]);

        return redirect()->route('product.list')->with('status', 'Cập nhật sản phẩm thành công');
    }

    function delete($id)
    {
        $product = Product::find($id);
        $product->variants()->delete();
        $product->delete();
        return redirect()->route('product.list')->with('status', 'Bạn đã xóa tạm thời thành công');
    }

    function action(Request $request)
    {
        $listCheck = $request->listCheck;
        $act = $request->act;
        if ($listCheck) {
            if ($act) {

                if ($act == 'delete') {
                    foreach ($listCheck as $id) {
                        $product = Product::find($id);
                        $product->variants()->delete();
                        $product->delete();
                    }
                    return redirect()->route('product.list')->with('status', 'Bạn đã xóa tạm thời thành công');
                }

                if ($act == "restore") {
                    foreach ($listCheck as $id) {
                        $product = Product::onlyTrashed()->find($id);
                        $product->variants()->restore();
                        $product->restore();
                    }
                    return redirect()->route('product.list')->with('status', 'Bạn đã khôi phục thành công');
                }

                if ($act == "forceDelete") {
                    foreach ($listCheck as $id) {
                        foreach ($listCheck as $id) {
                            $product = Product::onlyTrashed()->find($id);
                            $product->variants()->forceDelete();
                            $product->forceDelete();
                        }
                    }
                    return redirect()->route('product.list')->with('status', 'Bạn đã xóa vĩnh viễn thành công');
                }
            } else {
                return redirect()->back()->with('error', 'Bạn cần chọn tác vụ để thực hiện');
            }
        } else {
            return redirect()->back()->with('error', 'Bạn chưa chọn bản ghi để thực hiện');
        }
    }

    function convertStatus($id)
    {
        $product = Product::find($id);
        $product->update([
            'status' => !$product->status
        ]);
        return redirect()->route("product.list")->with('status', 'Cập nhật trạng thái thuộc tính thành công');
    }

    function feature($id)
    {
        $product = Product::find($id);
        $product->update([
            'featured' => !$product->featured,
        ]);
        return redirect()->back();
    }
}
