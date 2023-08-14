<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $kind = $request->input('kind');
        $user_count_active = User::count();
        $user_count_trash = User::onlyTrashed()->count();
        $count = [$user_count_active, $user_count_trash];

        $list_field = [
            'id' => 'ID',
            'name' => 'Họ tên',
            'email' => 'Email'
        ];
        if ($kind == "trash") {
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $users = User::onlyTrashed()->paginate(8);
        } else {
            $users = User::latest()->paginate(8);

            $list_act = [
                'delete' => 'Xóa tạm thời'
            ];
            $field = $request->field;
            $keyword = $request->input('keyword');
            if ($keyword) {
                $users = User::where($field, 'like', '%' . $keyword . '%')->paginate(8);
            }

            $keyword1 = $request->input('keyword1');

            if ($keyword1) {
                $users = User::where($field, 'like', '%' . $keyword1 . '%')->onlyTrashed()->paginate(8);
                $list_act = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                return view('admin.users.list-trash', compact('users', 'count', 'list_field', 'list_act'));
            }
        }

        return view("admin.users.list", compact('users', 'count', 'list_act', 'list_field'));
    }

    public function add()
    {
        $roles = Role::select('id', 'name')->get();
        return view('admin.users.add', compact('roles'));
    }

    public function store(UserAddRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $roleIds = $request->role_id;
        $user->roles()->attach($roleIds);
        // return $request->input();
        return redirect('admin/user/list')->with('status', 'đã thêm thành viên thành công');
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roleOfUser = $user->roles;

        $roles = Role::select('id', 'name')->get();

        return view('admin.users.edit', compact('user', 'roles', 'roleOfUser'));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        User::find($id)->update([
            'name' => $request->name,
        ]);
        if (!empty($request->password)) {
            User::find($id)->update([
                'password' => Hash::make($request->password)
            ]);
        }
        $user = User::find($id);
        $user->roles()->sync($request->role_id);
        return redirect()->route('user.list')->with('status', 'bạn đã cập nhật thông tin thành công');
    }

    public function changePassword($id)
    {
        $user = User::find($id);
        return view('admin.users.update-password', compact('user'));
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $messsages = array(
            'password.required' => 'Nhập mật khẩu',
            'new_password.required' => 'Nhập mật khẩu mới',
            'new_password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'new_confirm_password.same' => 'Các mật khẩu trên không trùng khớp, hãy thử lại',
        );
        $request->validate([
            'password' => ['required', new MatchOldPassword($id)],
            'new_password' => ['required','min:8'],
            'new_confirm_password' => ['same:new_password'],
        ],$messsages);

        $user->update(['password' => Hash::make($request->new_password)]);
        return redirect()->route('user.list')->with('status','Bạn đã cập nhật mật khẩu mới thành công');
    }

    public function delete($id)
    {
        if (Auth::id() != $id) {
            $user = User::find($id);
            $user->delete();
            return redirect()->route('user.list')->with('status', 'xóa thành công');
        }
    }

    public function action(Request $request)
    {
        $listcheck = $request->input('listcheck');
        if ($listcheck) {
            // mục đích để xóa chính mình ra khỏi tác vụ
            foreach ($listcheck as $k => $id) {
                if (Auth::id() == $id) {
                    unset($listcheck[$k]);
                }
            }
            $action = $request->input('act');
            if ($action) {
                if ($action == "delete") {
                    User::destroy($listcheck);
                    return redirect()->route('user.list')->with('status', 'Bạn đã xóa tạm thời');
                }

                if ($action == "restore") {
                    User::onlyTrashed()
                        ->whereIn('id', $listcheck)
                        ->restore();
                    return redirect()->route('user.list')->with('status', 'Bạn đã khôi phục thành công');
                }

                if ($action == "forceDelete") {

                    $users =  User::onlyTrashed()->whereIn('id', $listcheck)->get();
                    foreach ($users as $user) {
                        $user->roles()->detach();
                        $user->forceDelete();
                    }

                    return redirect()->route('user.list')->with('status', 'Bạn đã xóa vĩnh viễn');
                }
            }
            return redirect()->route('user.list')->with('error', 'bạn cần bấm "chọn" để thực hiện tác vụ');
        } else {
            return redirect()->route('user.list')->with('error', 'Bạn cần phải chọn thành viên để thực hiện tác vụ');
        }
    }
}
