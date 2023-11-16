<?php

namespace App\Http\Controllers\Admin;

use App\AttributeValue;
use App\Http\Controllers\Controller;
use App\Attribute;
use App\Http\Requests\AttributeValueRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminAttributeValueController extends Controller
{
    function list(Request $request)
    {
        $attributes = Attribute::where('status', 1)->get();

        $kind = $request->kind;

        $count_attribute_active = AttributeValue::count();

        $count_attribute_trash = AttributeValue::onlyTrashed()->count();

        $count = [$count_attribute_active, $count_attribute_trash];

        $list_field = [
            'id' => 'ID',
            'attribute_id' => 'Tên thuộc tính',
            'value' => 'Giá trị'
        ];

        if ($kind == 'trash') {
            $attributeValues = AttributeValue::onlyTrashed()->paginate(5);
            $list_act =
                [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
        } else {
            $attributeValues = AttributeValue::latest()->paginate(5);
            $list_act = [
                'delete' => 'Xóa tạm thời'
            ];

            if ($request->search) {
                $field = $request->field;
                $keyword = $request->input('keyword');
                if ($keyword) {
                    if ($field == 'attribute_id') {
                        $get_id = Attribute::where('name', 'like', '%' . $keyword . '%')->get();
                        if (count($get_id) > 0) {
                            foreach ($get_id as $item) {
                                $ids[] = $item->id;
                            }
                        } else {
                            $ids[] = 0;
                        }
                        $attributeValues = AttributeValue::whereIn($field, $ids)->paginate(5);
                    } else {
                        $attributeValues = AttributeValue::where($field, 'like', '%' . $keyword . '%')->paginate(5);
                    }
                }
                $keyword1 = $request->input('keyword1');

                if ($keyword1) {
                    if ($field == 'attribute_id') {
                        $get_id = Attribute::where('name', 'like', '%' . $keyword1 . '%')->get();
                        if (count($get_id) > 0) {
                            foreach ($get_id as $item) {
                                $ids[] = $item->id;
                            }
                        } else {
                            $ids[] = 0;
                        }
                        
                        $attributeValues = AttributeValue::whereIn($field, $ids)->onlyTrashed()->paginate(5);
                    } else {
                        $attributeValues = AttributeValue::where($field, 'like', '%' . $keyword1 . '%')->onlyTrashed()->paginate(5);
                    }

                    $list_act = [
                        'restore' => 'Khôi phục',
                        'forceDelete' => 'Xóa vĩnh viễn'
                    ];
                    return view('admin.attribute.value.list-trash', compact('attributes', 'attributeValues', 'count', 'list_field', 'list_act'));
                }
            }
        }

        return view('admin.attribute.value.list', compact('attributes', 'attributeValues', 'list_act', 'count', 'list_field'));
    }

    function add(AttributeValueRequest $request)
    {
        AttributeValue::create([
            'attribute_id' => $request->attribute_id,
            'value' => $request->value,
        ]);
        return redirect()->route('attribute.value.list')->with('status', 'Thêm giá trị thuộc tính thành công');
    }

    function edit($id)
    {
        $attributes = Attribute::all();
        $attributeValue = AttributeValue::find($id);
        return view("admin.attribute.value.edit", compact('attributeValue', 'attributes'));
    }

    function update(AttributeValueRequest $request, $id)
    {
        $attributeValue = AttributeValue::find($id);
        $attributeValue->update([
            'attribute_id' => $request->attribute_id,
            'value' => $request->value,
        ]);
        return redirect()->route('attribute.value.list')->with('status', 'Cập nhật giá trị thuộc tính thành công');
    }

    function delete($id)
    {
        $attributeValue = AttributeValue::find($id);

        $attributeValue->delete();
        return redirect()->route("attribute.value.list")->with('status', 'Xóa tạm thời giá trị thuộc tính thành công');
    }


    function action(Request $request)
    {
        $listCheck = $request->listcheck;
        $act = $request->act;
        if ($listCheck) {
            if ($act) {

                if ($act == 'delete') {
                    AttributeValue::destroy($listCheck);
                    return redirect()->route('attribute.value.list')->with('status', 'Xóa tạm thời giá trị thuộc tính thành công');
                }

                if ($act == "restore") {
                    AttributeValue::onlyTrashed()->whereIn('id', $listCheck)->restore();
                    return redirect()->route('attribute.value.list')->with('status', 'Khôi phục giá trị thuộc tính thành công');
                }

                if ($act == "forceDelete") {
                    AttributeValue::onlyTrashed()->whereIn('id', $listCheck)->forceDelete();
                    return redirect()->route('attribute.value.list')->with('status', 'Xóa vĩnh viễn giá trị thuộc tính thành công');
                }
            } else {
                return redirect()->back()->with('error', 'Bạn cần chọn tác vụ để thực hiện');
            }
        } else {
            return redirect()->back()->with('error', 'Bạn chưa chọn bản ghi để thực hiện');
        }
    }
}
