<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use Illuminate\Http\Request;
use App\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminPageController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'page']);
            return $next($request);
        });
    }

    function list(Request $request)
    {
        $kind = $request->kind;
        $count_active = Page::count();
        $count_trash = Page::onlyTrashed()->count();
        $count_pending = Page::where('status', 0)->count();
        $count_public = Page::where('status', 1)->count();
        $count = [$count_active, $count_trash, $count_pending, $count_public];

        $list_field = [
            'id' => 'ID',
            'name' => 'Tên trang',
        ];

        if ($kind == 'trash') {
            $pages = Page::onlyTrashed()->latest()->paginate(5);
            $list_act =
                [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
        } else {
            $pages = Page::latest()->paginate(5);
            $list_act = [
                'delete' => 'Xóa tạm thời'
            ];
            if ($kind == 'pending') {
                $pages = Page::where('status', 0)->latest()->paginate(5);
            }
            if ($kind == 'public') {
                $pages = Page::where('status', 1)->latest()->paginate(5);
            }
            $field = $request->field;
            $keyword = $request->input('keyword');
            if ($keyword) {
                $pages = Page::where($field, 'like', '%' . $keyword . '%')->paginate(5);
            }

            $keyword1 = $request->input('keyword1');

            if ($keyword1) {
                $pages = Page::where($field, 'like', '%' . $keyword1 . '%')->onlyTrashed()->paginate(5);
                $list_act = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                return view('admin.pages.list-trash', compact('pages', 'count', 'list_field', 'list_act'));
            }
        }

        return view('admin.pages.list', compact('pages', 'list_act', 'count', 'list_field'));
    }


    function add()
    {
        return view('admin.pages.add');
    }

    function store(PageRequest $request)
    {
        Page::create([
            'name' => $request->name,
            'content' => $request->content,
            'slug' => Str::slug($request->name, '-'),
            'user_id' => Auth::id(),
            'status' => $request->status
        ]);
        return redirect()->route('page.list')->with('status', 'Thêm trang thành công');
    }

    function edit($id)
    {
        $page = Page::find($id);

        return view('admin.pages.edit', compact('page'));
    }

    function update(PageRequest $request, $id)
    {
        Page::find($id)->update([
            'name' => $request->name,
            'content' => $request->content,
            'slug' => Str::slug($request->name, '-'),
            'user_id' => Auth::id(),
            'status' => $request->status
        ]);
        return redirect()->route('page.list')->with('status', 'Cập nhật trang thành công');
    }

    function delete($id)
    {
        $page = Page::find($id);
        $page->delete();
        return redirect()->route('page.list')->with('status', 'Xóa tạm thời thành công');
    }

    function action(Request $request)
    {
        $listCheck = $request->input('listCheck');
        if ($listCheck) {
            $act = $request->input('act');
            if ($act) {
                if ($act == 'delete') {
                    Page::destroy($listCheck);
                    return redirect()->route('page.list')->with('status', 'Xóa tạm thời thành công');
                }
                if ($act == "restore") {
                    Page::onlyTrashed()->whereIn('id', $listCheck)->restore();
                    return redirect()->route('page.list')->with('status', 'Khôi phục thành công');
                }
                if ($act == "forceDelete") {
                    Page::onlyTrashed()->whereIn('id', $listCheck)->forceDelete();
                    return redirect()->route('page.list')->with('status', 'Xóa vĩnh viễn thành công');
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
        $post = Page::find($id);
        $post->update([
            'status' => !$post->status
        ]);
        return redirect()->route('page.list')->with('status', 'Cập nhật trạng thái thành công');
    }
}
