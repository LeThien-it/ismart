<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    public function login()
    {
        // dd(Hash::make('12345678'));
        if (Auth::check()) {
            return redirect()->route('dashboard.show');
        }
        return view('admin.login');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('admin.login');
    }

    public function postLoginAdmin(Request $request)
    {
        //    dd(Hash::make('123456'));
        $remember = $request->has('remember_me') ? true : false;
        $messsages = array(
            'email.required' => 'Nhập email',
            'email.email' => 'Email chưa đúng định dạng',
            'password.required' => 'Nhập mật khẩu',
        );

        $validator = Validator::make($request->all(), [
            'email' => 'bail|required|email',
            'password' => 'required',
        ], $messsages);

        if ($validator->fails()) {
            return redirect('admin/')
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $remember)) {
            return redirect()->route('dashboard.show');
        } else {
            return back()->with('error', 'Thông tin đăng nhập không đúng');
        }
    }
}
