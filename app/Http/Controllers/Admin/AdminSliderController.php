<?php

namespace App\Http\Controllers\Admin;

use App\CategoryProduct;
use App\Http\Controllers\Controller;
use App\Http\Requests\SliderAddRequest;
use App\Http\Requests\SliderUpdateRequest;
use App\Slider;
use Illuminate\Http\Request;
use App\Traits\StorageImageTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminSliderController extends Controller
{
    use StorageImageTrait;

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'slider']);
            return $next($request);
        });
    }

    function list(Request $request)
    {
        $kind = $request->kind;
        $count_active = Slider::count();
        $count_trash = Slider::onlyTrashed()->count();
        $count_pending = Slider::where('status', 0)->count();
        $count_public = Slider::where('status', 1)->count();
        $count = [$count_active, $count_trash, $count_pending, $count_public];

        $list_field = [
            'id' => 'ID',
            'image_name' => 'Tên ảnh',
        ];

        if ($kind == 'trash') {
            $sliders = Slider::onlyTrashed()->latest()->paginate(5);
            $list_act =
                [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
        } else {
            $sliders = Slider::latest()->paginate(5);
            $list_act = [
                'delete' => 'Xóa tạm thời'
            ];
            if ($kind == 'pending') {
                $sliders = Slider::where('status', 0)->paginate(5);
            }
            if ($kind == 'public') {
                $sliders = Slider::where('status', 1)->paginate(5);
            }
            $field = $request->field;
            $keyword = $request->input('keyword');
            if ($keyword) {
                $sliders = Slider::where($field, 'like', '%' . $keyword . '%')->paginate(5);
            }

            $keyword1 = $request->input('keyword1');

            if ($keyword1) {
                $sliders = Slider::where($field, 'like', '%' . $keyword1 . '%')->onlyTrashed()->paginate(5);
                $list_act = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                return view('admin.sliders.list-trash', compact('sliders', 'count', 'list_field', 'list_act'));
            }
        }

        return view('admin.sliders.list', compact('sliders', 'list_act', 'count', 'list_field'));
    }
    function add()
    {
        $catProducts = CategoryProduct::where('parent_id',0)->get();
        return view('admin.sliders.add',compact('catProducts'));
    }

    function store(SliderAddRequest $request)
    {
        $dataMultipleImage = $this->uploadImageTrait($request->image_path, 'slider');
        Slider::create([
            'image_path' => $dataMultipleImage['file_path'],
            'image_name' => $dataMultipleImage['file_name'],
            'user_id' => Auth::id(),
            'status' => $request->status,
            'title' => $request->title,
            'box' => $request->box,
            'position' => $request->position,
            'cat_pro_id' => $request->cat_pro_id

        ]);


        return redirect()->route('slider.list')->with('status', 'Thêm hình ảnh thành công');
    }

    function edit($id)
    {
        $catProducts = CategoryProduct::where('parent_id',0)->get();
        $slider = Slider::find($id);
        return view('admin.sliders.edit', compact('slider','catProducts'));
    }

    function update(SliderUpdateRequest $request, $id)
    {
        $slider = Slider::find($id);
        $slider->update([
            'title' => $request->title,
            'status' => $request->status,
            'box' => $request->box,
            'position' => $request->position,
            'cat_pro_id' => $request->cat_pro_id
        ]);
        if ($request->hasFile('image_path')) {
            $path = Str::of($slider->image_path)->replace('/storage' . "/", "/");
            Storage::disk('public')->delete($path);
            $dataMultipleImage = $this->uploadImageTrait($request->image_path, 'slider');
            $slider->update([
                'image_path' => $dataMultipleImage['file_path'],
                'image_name' => $dataMultipleImage['file_name'],
            ]);
        }

        return redirect()->route('slider.list')->with('status', 'Cập nhật hình ảnh thành công');
    }

    function delete($id)
    {
        Slider::find($id)->delete();
        return redirect()->route('slider.list')->with('status', 'Xóa tạm thời hình ảnh thành công');
    }

    function action(Request $request)
    {
        $listCheck = $request->input('listCheck');
        if ($listCheck) {
            $act = $request->input('act');
            if ($act) {
                if ($act == 'delete') {
                    Slider::destroy($listCheck);
                    return redirect()->route('slider.list')->with('status', 'Xóa tạm thời hình ảnh thành công');
                }
                if ($act == "restore") {
                    Slider::onlyTrashed()->whereIn('id', $listCheck)->restore();
                    return redirect()->route('slider.list')->with('status', 'Khôi phục hình ảnh thành công');
                }
                if ($act == "forceDelete") {
                    foreach ($listCheck as $id) {
                        $slider = Slider::onlyTrashed()->find($id);
                        $path = Str::of($slider->image_path)->replace('/storage' . "/", "/");
                        Storage::disk('public')->delete($path);
                        $slider->forceDelete();
                    }
                    return redirect()->route('slider.list')->with('status', 'Xóa vĩnh viễn hình ảnh thành công');
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
        $slider = Slider::find($id);
        $slider->update([
            'status' => !$slider->status
        ]);
        return redirect()->route('slider.list')->with('status', 'Cập nhật trạng thái hình ảnh thành công');
    }
}
