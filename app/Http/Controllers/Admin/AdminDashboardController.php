<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'dashboard']);
            return $next($request);
        });
    }
    public function show()
    {
        $orders = Order::paginate(5);
        $order_success = Order::where('status',3)->get();
        $count_order_success = count($order_success);//đơn hàng thành công
        $count_order_Processing = count(Order::where('status',1)->get());//đang xử lý
        $count_order_delivering = count(Order::where('status',2)->get());//đang giao
        $count_order_cancel = count(Order::where('status',4)->get());//hủy đơn hàng
        $sales = 0;
        foreach($order_success as $i){
            $sales += $i->total;
        }
        $sales = number_format($sales,0,'.','.');//Doanh số
        $count = [$sales,$count_order_success,$count_order_Processing,$count_order_delivering,$count_order_cancel];
        // $order_success = Order::where('')
        return view('admin.dashboard',compact('count','orders'));
    }
}
