<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'customer']);
            return $next($request);
        });
    }

    function list(Request $request)
    {
        $kind = $request->kind;
        $count_active = Customer::count();
        $count_trash = Customer::onlyTrashed()->count();

        $count = [$count_active, $count_trash];
        $list_field = [
            'id' => 'ID',
            'name' => 'Khách hàng',
            'email' => 'Email',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
        ];

        if ($kind == 'trash') {
            $customers = Customer::onlyTrashed()->paginate(8);
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn',
            ];
        } else {
            $customers = Customer::latest()->paginate(8);
            $list_act = [
                'delete' => 'Xóa tạm thời',
            ];

            $field = $request->field;
            $keyword = $request->input('keyword');
            if ($keyword) {
                $customers = Customer::where(
                    $field,
                    'like',
                    '%' . $keyword . '%'
                )->paginate(8);
            }
            $keyword1 = $request->input('keyword1');

            if ($keyword1) {
                $customers = Customer::where(
                    $field,
                    'like',
                    '%' . $keyword1 . '%'
                )
                    ->onlyTrashed()
                    ->paginate(8);
                $list_act = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn',
                ];
                return view(
                    'admin.customers.list-trash',
                    compact('customers', 'list_field', 'list_act', 'count')
                );
            }
        }
        return view('admin.customers.list',compact('customers', 'list_field', 'list_act', 'count'));
    }

    function delete($id)
    {
        $customer = Customer::find($id);
        $customer->ratings()->delete();
        $customer->orders()->delete();

        $customer->delete();
        return redirect()
            ->route('customer.list')
            ->with('status', 'Xóa tạm thời khách hàng thành công');
    }

    function action(Request $request)
    {
        $listCheck = $request->listCheck;
        $act = $request->act;
        if ($listCheck) {
            if ($act) {
                if ($act == 'delete') {
                    foreach ($listCheck as $id) {
                        $customer = Customer::find($id);
                        if ($customer->ratings) {
                            $customer->ratings()->delete();
                        }
                        if ($customer->orders) {
                            $customer->orders()->delete();
                        }
                        $customer->delete();
                    }
                    return redirect()
                        ->route('customer.list')
                        ->with('status', 'Xóa tạm thời khách hàng thành công');
                }

                if ($act == 'restore') {
                    foreach ($listCheck as $id) {
                        $customer = Customer::onlyTrashed()->find($id);
                        if ($customer->ratings) {
                            $customer->ratings()->restore();
                        }
                        if ($customer->orders) {
                            $customer->orders()->restore();
                        }

                        $customer->restore();
                    }
                    return redirect()
                        ->route('customer.list')
                        ->with('status', 'Khôi phục khách hàng thành công');
                }

                if ($act == 'forceDelete') {
                    foreach ($listCheck as $id) {
                        $customer = Customer::onlyTrashed()->find($id);
                        if ($customer->ratings) {
                            $customer->ratings()->forceDelete();
                        }
                        if ($customer->orders) {
                            $orders = $customer->orders;
                            foreach ($orders as $order) {
                                foreach($order->orderDetails as $orderDetail){
                                    $orderDetail->delete();
                                }
                            }
                            $customer->orders()->forceDelete();
                        }
                        $customer->forceDelete();
                    }
                    return redirect()
                        ->route('customer.list')
                        ->with('status', 'Xóa vĩnh viễn khách hàng thành công');
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
