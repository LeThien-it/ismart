<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Product;
use App\Rating;
use Illuminate\Http\Request;

class AdminRatingController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'rating']);
            return $next($request);
        });
    }

    function list(Request $request)
    {
        $kind = $request->kind;
        $count_active = Rating::count();
        $count_trash = Rating::onlyTrashed()->count();
        $count_approved = Rating::where('status', 1)->count();
        $count_not_approved = Rating::where('status', 0)->count();

        $count = [$count_active, $count_trash, $count_approved, $count_not_approved];

        $list_field = [
            'id' => 'ID',
            'customer_id' => 'Khách hàng',
            'product_id' => 'Tên sản phẩm',
            'num_star' => 'Số sao',
        ];

        if ($kind == 'trash') {
            $ratings = Rating::onlyTrashed()->paginate(8);
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
        } else {
            $ratings = Rating::latest()->paginate(8);

            $list_act = [
                'delete' => 'Xóa tạm thời'
            ];

            if ($kind == 'approved') {
                $ratings = Rating::where('status', 1)->paginate(8);
            }
            if ($kind == 'not_approved') {
                $ratings = Rating::where('status', 0)->paginate(8);
            }

            $field = $request->field;
            $keyword = $request->input('keyword');
            if ($keyword) {
                if ($field == 'customer_id') {
                    $get_id = Customer::where('name', 'like', '%' . $keyword . '%')->get();
                    if (count($get_id) > 0) {
                        foreach ($get_id as $item) {
                            $ids[] = $item->id;
                        }
                    } else {
                        $ids[] = 0;
                    }
                    $ratings = Rating::whereIn($field, $ids)->paginate(8);
                } elseif ($field == 'product_id') {
                    $get_id = Product::where('name', 'like', '%' . $keyword . '%')->get();
                    if (count($get_id) > 0) {
                        foreach ($get_id as $item) {
                            $ids[] = $item->id;
                        }
                    } else {
                        $ids[] = 0;
                    }
                    $ratings = Rating::whereIn($field, $ids)->paginate(8);
                } else {
                    $ratings = Rating::where($field, 'like', '%' . $keyword . '%')->paginate(8);
                }
            }
            $keyword1 = $request->input('keyword1');

            if ($keyword1) {
                if ($field == 'customer_id') {
                    $get_id = Customer::where('name', 'like', '%' . $keyword1 . '%')->get();
                    if (count($get_id) > 0) {
                        foreach ($get_id as $item) {
                            $ids[] = $item->id;
                        }
                    } else {
                        $ids[] = 0;
                    }
                    $ratings = Rating::whereIn($field, $ids)->onlyTrashed()->paginate(8);
                } elseif ($field == 'product_id') {
                    $get_id = Product::where('name', 'like', '%' . $keyword1 . '%')->get();
                    if (count($get_id) > 0) {
                        foreach ($get_id as $item) {
                            $ids[] = $item->id;
                        }
                    } else {
                        $ids[] = 0;
                    }
                    $ratings = Rating::whereIn($field, $ids)->onlyTrashed()->paginate(8);
                } else {
                    $ratings = Rating::where($field, 'like', '%' . $keyword1 . '%')->onlyTrashed()->paginate(8);
                }

                $list_act = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                return view('admin.ratings.list-trash', compact('ratings', 'list_field', 'list_act', 'count'));
            }
        }
        return view('admin.ratings.list', compact('ratings', 'list_field', 'list_act', 'count'));
    }

    function delete($id)
    {
        $rating = Rating::find($id);
        $rating->delete();
        return redirect()->route('rating.list')->with('status', 'Bạn đã xóa tạm thời thành công');
    }

    function action(Request $request)
    {
        $listCheck = $request->listCheck;
        $act = $request->act;
        if ($listCheck) {
            if ($act) {
                if ($act == 'delete') {
                    Rating::destroy($listCheck);
                    return redirect()->route('rating.list')->with('status', 'Bạn đã xóa tạm thời thành công');
                }

                if ($act == "restore") {
                    Rating::onlyTrashed()->whereIn('id', $listCheck)->restore();
                    return redirect()->route('rating.list')->with('status', 'Bạn đã khôi phục thành công');
                }

                if ($act == "forceDelete") {
                    Rating::onlyTrashed()->whereIn('id', $listCheck)->forceDelete();
                    return redirect()->route('rating.list')->with('status', 'Bạn đã xóa vĩnh viễn thành công');
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
        $rating = Rating::find($id);
        $rating->update([
            'status' => !$rating->status
        ]);
        return redirect()->route("rating.list")->with('status', 'Cập nhật trạng thái thuộc tính thành công');
    }
}
