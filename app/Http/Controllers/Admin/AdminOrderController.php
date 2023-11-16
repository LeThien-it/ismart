<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetail;
use App\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'order']);
            return $next($request);
        });
    }
    function list(Request $request)
    {
        $kind = $request->kind;

        $count_all = Order::count(); //tất cả
        $count_trash = Order::onlyTrashed()->count(); //vô hiệu hóa
        $count_processing = Order::where('status', 1)->count(); //đang xử lý
        $count_delivering = Order::where('status', 2)->count(); //đang giao hàng
        $count_done = Order::where('status', 3)->count(); //Hoàn thành
        $count_cancel = Order::where('status', 4)->count(); //Hủy đơn hàng

        $count = [
            $count_all,
            $count_processing,
            $count_delivering,
            $count_done,
            $count_cancel,
            $count_trash,
        ];

        //Các trường để tìm kiếm
        $list_field = [
            'id' => 'ID',
            'customer_id' => 'Khách hàng',
            'order_code' => 'Mã đơn hàng',
        ];

        //Chức năng chọn tác vụ:
        if ($kind == 'trash') {
            $orders = Order::onlyTrashed()->paginate(5);
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn',
            ];
        } else {
            $orders = Order::latest()->paginate(5);
            $list_act = [
                'delete' => 'Xóa tạm thời',
            ];
            if ($kind == 'processing') {
                $orders = Order::where('status', 1)
                    ->latest()
                    ->paginate(5);
            }
            if ($kind == 'delivering') {
                $orders = Order::where('status', 2)
                    ->latest()
                    ->paginate(5);
            }
            if ($kind == 'done') {
                $orders = Order::where('status', 3)
                    ->latest()
                    ->paginate(5);
            }
            if ($kind == 'cancel') {
                $orders = Order::where('status', 4)
                    ->latest()
                    ->paginate(5);
            }

            $field = $request->field;
            $keyword = $request->input('keyword');

            if ($keyword) {
                if ($field == 'customer_id') {
                    $get_id = Customer::where(
                        'name',
                        'like',
                        '%' . $keyword . '%'
                    )->get();
                    if (count($get_id) > 0) {
                        foreach ($get_id as $item) {
                            $ids[] = $item->id;
                        }
                    } else {
                        $ids[] = 0;
                    }
                    $orders = Order::whereIn($field, $ids)->paginate(5);
                } else {
                    $orders = Order::where(
                        $field,
                        'like',
                        '%' . $keyword . '%'
                    )->paginate(5);
                }
            }

            $keyword1 = $request->input('keyword1');

            if ($keyword1) {
                if ($field == 'customer_id') {
                    $get_id = Customer::where(
                        'name',
                        'like',
                        '%' . $keyword1 . '%'
                    )->get();
                    if (count($get_id) > 0) {
                        foreach ($get_id as $item) {
                            $ids[] = $item->id;
                        }
                    } else {
                        $ids[] = 0;
                    }
                    $orders = Order::whereIn($field, $ids)
                        ->onlyTrashed()
                        ->paginate(5);
                } else {
                    $orders = Order::where(
                        $field,
                        'like',
                        '%' . $keyword1 . '%'
                    )
                        ->onlyTrashed()
                        ->paginate(5);
                }
                $list_act = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn',
                ];
                return view(
                    'admin.order.list-trash',
                    compact('orders', 'list_field', 'list_act', 'count')
                );
            }
        }
        return view(
            'admin.order.list',
            compact('orders', 'list_field', 'list_act', 'count')
        );
    }

    function detail(Request $request, $id)
    {
        $order = Order::find($id);
        $order_details = $order->orderDetails;
        
        return view('admin.order.detail', compact('order'));
    }

    function update(Request $request, $id)
    {
        $order = Order::find($id);
        $order->update([
            'status' => $request->status,
        ]);
        $order_details = $order->orderDetails;
        if ($order->status == 3 && $order->is_updated == false) {
            if (count($order_details) > 1) {
                // dd('thiện pro');
                foreach ($order_details as $order_detail) {
                    $variant = ProductVariant::find(
                        $order_detail->product_variant_id
                    );
                    $variant->increment('sales_count');
                }
            } else {
                $variant = ProductVariant::find(
                    $order_details->product_variant_id
                );
                $variant->increment('sales_count');
            }
            $order->update(['is_updated' => true]);
        }
        return redirect()
            ->route('order.list')
            ->with('status', 'Cập nhật tình trạng đơn hàng thành công');
    }

    function delete($id)
    {
        $order = Order::find($id);
        $order->delete();
        return redirect()
            ->back()
            ->with('status', 'Xóa tạm thời đơn hàng thành công');
    }

    function action(Request $request)
    {
        $listCheck = $request->listCheck;
        $act = $request->act;
        if ($listCheck) {
            if ($act) {
                if ($act == 'delete') {
                    foreach ($listCheck as $id) {
                        $order = Order::find($id);
                        $order->delete();
                    }
                    return redirect()
                        ->back()
                        ->with('status', 'Xóa tạm thời đơn hàng thành công');
                }

                if ($act == 'restore') {
                    foreach ($listCheck as $id) {
                        $order = Order::onlyTrashed()->find($id);
                        $order->restore();
                    }
                    return redirect()
                        ->route('order.list')
                        ->with('status', 'Khôi phục đơn hàng thành công');
                }

                if ($act == 'forceDelete') {
                    foreach ($listCheck as $id) {
                        $order = Order::onlyTrashed()->find($id);

                        foreach ($order->orderDetails as $item) {
                            $path = Str::of($item->product_image)->replace(
                                '/storage' . '/',
                                '/'
                            );
                            Storage::disk('public')->delete($path); // mục đích để xóa đường dẫn ảnh cũ trong storage trước khi update
                        }
                        $order->orderDetails()->forceDelete();
                        $order->forceDelete();
                    }
                    return redirect()
                        ->route('order.list')
                        ->with('status', 'Xóa vĩnh viễn đơn hàng thành công');
                }
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Bạn cần chọn tác vụ để thực hiện');
            }
        } else {
            return redirect()
                ->back()
                ->with('error', 'Bạn chưa chọn bản ghi để thực hiện');
        }
    }
}
