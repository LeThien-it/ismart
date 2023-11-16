<?php

namespace App\Http\Controllers\Frontend;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Mail\OrderConfirm;
use App\Order;
use App\OrderDetail;
use App\ProductVariant;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ShoppingCartController extends Controller
{
    function show()
    {
        return view('frontend.cart.show');
    }
    function add(Request $request, $id)
    {
        $slug = $request->slug;
        $variant = ProductVariant::find($id);
        foreach ($variant->attributeValues as $i) {
            if (strtolower($i->attribute->name) == 'màu sắc') {
                $color = $i->value;
            }
        }
        Cart::add([
            'id' => $variant->id,
            'name' => $variant->product->name,
            'qty' => 1,
            'price' => $variant->price,
            'options' => [
                'color' => $color,
                'image_path' => $variant->feature_image_path,
                'productSlug' => $variant->product->slug,
                'slug' => $slug,
            ],
        ]);
        $src = asset($variant->feature_image_path);
        $num = Cart::count();
        return response()->json([
            'code' => 200,
            'src' => $src,
            'name' => $variant->product->name,
            'num' => $num,
        ]);
    }

    function update(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;
        $cartItem = Cart::get($rowId);
        Cart::update($rowId, $qty);
        $subTotal = number_format($cartItem->price * $qty, 0, ',', '.');
        $num_pro = Cart::count();
        $total = Cart::total();
        return response()->json([
            'code' => 200,
            'subTotal' => $subTotal,
            'total' => $total,
            'num_pro' => $num_pro,
            'qty' => $qty,
        ]);
    }

    function delete($id)
    {
        Cart::remove($id);
        return redirect()->back();
    }

    function destroy()
    {
        Cart::destroy();
        return redirect()->back();
    }

    function pay()
    {
        return view('frontend.cart.pay');
    }

    function postPay(Request $request)
    {
        $code = substr(md5(microtime()), rand(0, 26), 8);
        $uppercase_code = Str::upper($code);
        $order_code = 'ISM-' . $uppercase_code;

        $validator = Validator::make($request->all(), []);

        $messsages = [
            'name.required' => 'nhập họ và tên',
            'email.required' => 'nhập email',
            'phone.required' => 'nhập số điện thoại',
            'address.required' => 'nhập địa chỉ',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
            ],
            $messsages
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $customer = Customer::firstOrCreate([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $order = Order::create([
            'order_code' => $order_code,
            'customer_id' => $customer->id,
            'total' => str_replace('.', '', Cart::subtotal()),
            'note' => $request->note ?? '',
        ]);

        foreach (Cart::content() as $row) {
            $str = $row->options['image_path'];
            $path = str_replace('/storage/', 'public/', $str);
            // dd($path);
            $filename = Str::afterLast($str, '/');
            $fileNameHash = Str::random(27) . "." . $filename;

            $checkFile = "/public/order_detail/$fileNameHash";

            $orderStorage = "/storage/order_detail/$fileNameHash";
            // $files = Storage::copy($path,"public/order_detail/$filename");
            if (!(Storage::exists($checkFile))) {
                $files = Storage::copy($path, $checkFile);
            }
           
            OrderDetail::create([
                'order_id' => $order->id,
                'product_name' => $row->name,
                'product_color' => $row->options['color'],
                'product_image' => $orderStorage,
                'product_variant_id' => $row->id,
                'qty' => $row->qty,
                'price' => $row->price,
            ]);
        }
        

        $data['info'] = $customer;
        $data['cart'] = Cart::content();
        $data['total'] = str_replace('.', '', Cart::subtotal());
        $data['order_code'] = $order->order_code;
        $emailCustomer = $request->email;
        $nameCustomer = $request->name;
        Mail::to($emailCustomer, $nameCustomer)->send(new OrderConfirm($data));
        Cart::destroy();
        return view('frontend.cart.thank');
    }
}
