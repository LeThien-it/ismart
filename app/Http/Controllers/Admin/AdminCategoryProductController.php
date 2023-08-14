<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use App\CategoryProduct;
use App\Components\Recursive;
use App\Http\Requests\CategoryProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminCategoryProductController extends Controller
{
    function list(Request $request)
    {
        $htmlOption = $this->getCategory($parentId = '');

        $kind = $request->kind;
        $count_active = CategoryProduct::count();
        $count_trash = CategoryProduct::onlyTrashed()->count();
        $count = [$count_active, $count_trash];
        $list_field = [
            'id' => 'ID',
            'name' => 'Tên danh mục',
        ];

        if ($kind == 'trash') {
            $catProducts = CategoryProduct::onlyTrashed()->latest()->paginate(8);

            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
        } else {
            $catProducts = CategoryProduct::latest()->paginate(8);
            $list_act = [
                'delete' => 'Xóa tạm thời'
            ];

            if ($request->search) {
                $field = $request->field;
                $keyword = $request->input('keyword');
                if ($keyword) {
                    $catProducts = CategoryProduct::where($field, 'like', '%' . $keyword . '%')->paginate(8);
                }
                $keyword1 = $request->input('keyword1');

                if ($keyword1) {
                    $catProducts = CategoryProduct::where($field, 'like', '%' . $keyword1 . '%')->onlyTrashed()->paginate(8);
                    $list_act = [
                        'restore' => 'Khôi phục',
                        'forceDelete' => 'Xóa vĩnh viễn'
                    ];
                    return view('admin.categoryProduct.list-trash', compact('htmlOption', 'catProducts', 'count', 'list_field', 'list_act'));
                }
            }
        }

        return view('admin.categoryProduct.list', compact('htmlOption', 'catProducts', 'count', 'list_field', 'list_act'));
    }

    function getCategory($parentId)
    {
        $data = CategoryProduct::all();
        $recursive = new Recursive();
        $htmlOption = $recursive->itemRecursive($parentId, 0, '', $data);
        return $htmlOption;
    }

    function add(CategoryProductRequest $request)
    {
        CategoryProduct::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'class' => $request->class,
            'position' => $request->position,
            'slug' => Str::slug($request->name, '-'),
            'user_id' => Auth::id()
        ]);
        return redirect()->route('product.cat.list')->with('status', 'Thêm danh mục thành công');
    }

    function edit($id)
    {
        $catProduct = CategoryProduct::find($id);
        $htmlOption = $this->getCategory($catProduct->parent_id);
        return view("admin.categoryProduct.edit", compact('htmlOption', 'catProduct'));
    }
    function update(CategoryProductRequest $request, $id)
    {
        CategoryProduct::find($id)->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'slug' => Str::slug($request->name, '-'),
            'class' => $request->class,
            'position' => $request->position,
        ]);

        return redirect()->route("product.cat.list")->with('status', 'Cập nhật danh mục thành công');
    }

    function getDeleteRecursive($id)
    {
        $data = CategoryProduct::find($id);
        $recursive = new Recursive();
        $deleteRecursive = $recursive->deleteRecursive($data);
        return $deleteRecursive;
    }

    function getRestoreRecursive($id)
    {
        $recursive = new Recursive();
        $restoreRecursive = $recursive->restoreRecursive($id,'App\CategoryProduct');
        return $restoreRecursive;
    }
    function delete($id)
    {
        $catPost = CategoryProduct::find($id);
        $deleteRecursive = $this->getDeleteRecursive($id); //mục đích xóa 1 thằng cha thì các thằng con sẽ tự động xóa theo
        $catPost->delete();
        return redirect()->route("product.cat.list")->with('status', 'Xóa tạm thời danh mục thành công');
    }

    function action(Request $request)
    {
        $listCheck = $request->listCheck;
        $act = $request->act;
        if ($listCheck) {
            if ($act) {

                if ($act == 'delete') {
                    foreach ($listCheck as $id) {
                        $catProduct = CategoryProduct::find($id);
                        $deleteRecursive = $this->getDeleteRecursive($id);
                        $catProduct->delete();
                    }
                    return redirect()->route('product.cat.list')->with('status', 'Xóa tạm thời danh mục thành công');
                }

                if ($act == "restore") {
                    foreach ($listCheck as $id) {
                        $catProduct = CategoryProduct::onlyTrashed()->find($id);
                        if ($catProduct) {
                            $this->getRestoreRecursive($id);
                        }
                    }
                    return redirect()->route('product.cat.list')->with('status', 'Khôi phục danh mục thành công');
                }

                if ($act == "forceDelete") {
                    $catProduct = CategoryProduct::onlyTrashed()->whereIn('id', $listCheck)->forceDelete();

                    return redirect()->route('product.cat.list')->with('status', 'Xóa vĩnh viễn danh mục thành công');
                }
            } else {
                return redirect()->back()->with('error', 'Bạn cần chọn tác vụ để thực hiện');
            }
        } else {
            return redirect()->back()->with('error', 'Bạn chưa chọn bản ghi để thực hiện');
        }
    }
}
