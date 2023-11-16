<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Attribute;
use App\Http\Requests\AttributeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAttributeController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'attribute']);
            return $next($request);
        });
    }

    function list(Request $request)
    {
        $kind = $request->kind;
        $count_attribute_active = Attribute::count();
        $count_attribute_trash = Attribute::onlyTrashed()->count();
        $count = [$count_attribute_active, $count_attribute_trash];
        $list_field = [
            'id' => 'ID',
            'name' => 'Tên thuộc tính'
        ];

        if ($kind == 'trash') {
            $attributes = Attribute::onlyTrashed()->paginate(5);
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
        } else {
            $attributes = Attribute::latest()->paginate(5);
            $list_act = [
                'delete' => 'Xóa tạm thời'
            ];

            if ($request->search) {
                $field = $request->field;
                $keyword = $request->input('keyword');
                if ($keyword) {
                    $attributes = Attribute::where($field, 'like', '%' . $keyword . '%')->paginate(5);
                }
                $keyword1 = $request->input('keyword1');

                if ($keyword1) {
                    $attributes = Attribute::where($field, 'like', '%' . $keyword1 . '%')->onlyTrashed()->paginate(5);
                    
                    $list_act = [
                        'restore' => 'Khôi phục',
                        'forceDelete' => 'Xóa vĩnh viễn'
                    ];
                    return view('admin.attribute.list-trash', compact('attributes', 'count', 'list_field', 'list_act'));
                }
            }
        }

        return view('admin.attribute.list', compact('attributes', 'list_act', 'count', 'list_field'));
    }

    function add(AttributeRequest $request)
    {
        Attribute::create([
            'name' => $request->name,
            'status' => $request->status,
            'user_id' => Auth::id()
        ]);
        return redirect()->route('attribute.list')->with('status', 'Thêm thuộc tính thành công');
    }

    function edit($id)
    {
        $attribute = Attribute::find($id);
        return view("admin.attribute.edit", compact('attribute'));
    }

    function update(AttributeRequest $request, $id)
    {
        $attribute = Attribute::find($id);
        $attribute->update([
            'name' => $request->name,
            'status' => $request->status
        ]);
        return redirect()->route("attribute.list")->with('status', 'Cập nhật thuộc tính thành công');
    }

    function delete($id)
    {
        $attribute = Attribute::find($id);
        if ($attribute->values) {
            $attribute->values()->delete();
        }
        $attribute->delete();
        return redirect()->route("attribute.list")->with('status', 'Xóa tạm thời thuộc tính thành công');
    }

    function action(Request $request)
    {
        $listCheck = $request->listcheck;
        $act = $request->act;
        if ($listCheck) {
            if ($act) {

                if ($act == 'delete') {
                    foreach ($listCheck as $id) {
                        $attribute = Attribute::find($id);
                        if ($attribute->values) {
                            $attribute->values()->delete();
                        }
                        $attribute->delete();
                    }
                    return redirect()->route('attribute.list')->with('status', 'Xóa tạm thời thuộc tính thành công');
                }

                if ($act == "restore") {
                    foreach ($listCheck as $id) {
                        $attribute = Attribute::onlyTrashed()->find($id);
                        $attribute->values()->restore();
                        $attribute->restore();
                    }
                    return redirect()->route('attribute.list')->with('status', 'Khôi phục thuộc tính thành công');
                }

                if ($act == "forceDelete") {
                    foreach ($listCheck as $id) {
                        $attribute = Attribute::onlyTrashed()->find($id);
                        if ($attribute->values) {
                            $attribute->values()->forceDelete();
                        }
                        $attribute->forceDelete();
                    }
                    return redirect()->route('attribute.list')->with('status', 'Xóa vĩnh viễn thuộc tính thành công');
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
        $attribute = Attribute::find($id);
        $attribute->update([
            'status' => !$attribute->status
        ]);
        return redirect()->route("attribute.list")->with('status', 'Cập nhật trạng thái thuộc tính thành công');
    }
}
