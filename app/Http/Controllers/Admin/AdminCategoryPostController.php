<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\CategoryPost;
use App\Components\Recursive;
use App\Http\Requests\CategoryPostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminCategoryPostController extends Controller
{
    function list(Request $request)
    {
        $htmlOption = $this->getCategory($parentId = '');

        $kind = $request->kind;
        $count_active = CategoryPost::count();
        $count_trash = CategoryPost::onlyTrashed()->count();
        $count = [$count_active, $count_trash];
        $list_field = [
            'id' => 'ID',
            'name' => 'Tên danh mục',
        ];

        if ($kind == 'trash') {
            $catPosts = CategoryPost::onlyTrashed()->latest()->paginate(8);

            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
        } else {
            $catPosts = CategoryPost::latest()->paginate(8);
            $list_act = [
                'delete' => 'Xóa tạm thời'
            ];

            if ($request->search) {
                $field = $request->field;
                $keyword = $request->input('keyword');
                if ($keyword) {
                    $catPosts = CategoryPost::where($field, 'like', '%' . $keyword . '%')->paginate(8);
                }
                $keyword1 = $request->input('keyword1');

                if ($keyword1) {
                    $catPosts = CategoryPost::where($field, 'like', '%' . $keyword1 . '%')->onlyTrashed()->paginate(8);
                    $list_act = [
                        'restore' => 'Khôi phục',
                        'forceDelete' => 'Xóa vĩnh viễn'
                    ];
                    return view('admin.categoryPost.list-trash', compact('htmlOption', 'catPosts', 'count', 'list_field', 'list_act'));
                }
            }
        }

        return view('admin.categoryPost.list', compact('htmlOption', 'catPosts', 'count', 'list_field', 'list_act'));
    }

    function getCategory($parentId)
    {
        $data = CategoryPost::all();
        $recursive = new Recursive();
        $htmlOption = $recursive->itemRecursive($parentId, 0, '', $data);
        return $htmlOption;
    }

    function add(CategoryPostRequest $request)
    {
        CategoryPost::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'slug' => Str::slug($request->name, '-'),
            'position' => $request->position,
            'user_id' => Auth::id()
        ]);
        return redirect()->route('post.cat.list')->with('status', 'Thêm danh mục thành công');
    }

    function edit($id)
    {
        $catPost = CategoryPost::find($id);
        $htmlOption = $this->getCategory($catPost->parent_id);
        return view("admin.categoryPost.edit", compact('htmlOption', 'catPost'));
    }

    function update(CategoryPostRequest $request, $id)
    {
        CategoryPost::find($id)->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'slug' => Str::slug($request->name, '-'),
            'position' => $request->position,

        ]);
        return redirect()->route("post.cat.list")->with('status', 'Cập nhật danh mục thành công');
    }

    function getDeleteRecursive($id)
    {
        $data = CategoryPost::find($id);
        $recursive = new Recursive();
        $deleteRecursive = $recursive->deleteRecursive($data);
        return $deleteRecursive;
    }

    function getRestoreRecursive($id)
    {
        $recursive = new Recursive();
        $restoreRecursive = $recursive->restoreRecursive($id,'App\CategoryPost');
        return $restoreRecursive;
    }
    function delete($id)
    {
        $catPost = CategoryPost::find($id);
        $deleteRecursive = $this->getDeleteRecursive($id); //mục đích xóa 1 thằng cha thì các thằng con sẽ tự động xóa theo
        $catPost->delete();
        return redirect()->route("post.cat.list")->with('status', 'Xóa tạm thời danh mục thành công');
    }

    function action(Request $request)
    {
        $listCheck = $request->listCheck;
        $act = $request->act;
        if ($listCheck) {
            if ($act) {

                if ($act == 'delete') {
                    foreach ($listCheck as $id) {
                        $catPost = CategoryPost::find($id);
                        $deleteRecursive = $this->getDeleteRecursive($id);
                        $catPost->delete();
                    }
                    return redirect()->route('post.cat.list')->with('status', 'Xóa tạm thời danh mục thành công');
                }

                if ($act == "restore") {
                    foreach ($listCheck as $id) {
                        $catPost = CategoryPost::onlyTrashed()->find($id);
                        if ($catPost) {
                            $this->getRestoreRecursive($id);
                        }
                    }
                    return redirect()->route('post.cat.list')->with('status', 'Khôi phục danh mục thành công');
                }

                if ($act == "forceDelete") {
                    $catPost = CategoryPost::onlyTrashed()->whereIn('id', $listCheck)->forceDelete();

                    return redirect()->route('post.cat.list')->with('status', 'Xóa vĩnh viễn danh mục thành công');
                }
            } else {
                return redirect()->back()->with('error', 'Bạn cần chọn tác vụ để thực hiện');
            }
        } else {
            return redirect()->back()->with('error', 'Bạn chưa chọn bản ghi để thực hiện');
        }
    }
}
