<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Permission;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminRoleController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'role']);
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $kind = $request->input('kind');
        $role_count_active = Role::count();
        $role_count_trash = Role::onlyTrashed()->count();
        $count = [$role_count_active, $role_count_trash];

        $list_field = [
            'id' => 'ID',
            'name' => 'Tên nhóm quyền',
        ];
        if ($kind == "trash") {
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $roles = Role::onlyTrashed()->paginate(4);
        } else {
            $roles = Role::latest()->paginate(8);

            $list_act = [
                'delete' => 'Xóa tạm thời'
            ];
            $field = $request->field;
            $keyword = $request->input('keyword');
            if ($keyword) {
                $roles = Role::where($field, 'like', '%' . $keyword . '%')->paginate(8);
            }

            $keyword1 = $request->input('keyword1');

            if ($keyword1) {
                $roles = Role::where($field, 'like', '%' . $keyword1 . '%')->onlyTrashed()->paginate(8);
                $list_act = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                return view('admin.roles.list-trash', compact('roles', 'count', 'list_field', 'list_act'));
            }
        }

        return view("admin.roles.list", compact('roles', 'count', 'list_act', 'list_field'));
    }

    function add()
    {
        $permissionParents = Permission::where('parent_id', 0)->get();
        return view('admin.roles.add', compact('permissionParents'));
    }

    function store(RoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'user_id' => Auth::id()
        ]);

        $role->permissions()->attach($request->permission_id);
        return redirect()->route('role.list')->with('status', 'Thêm nhóm quyền thành công');
    }

    function edit($id)
    {
        $role = Role::find($id);
        $permissionParents = Permission::where('parent_id', 0)->get();
        $permissionIds = $role->permissions;
        return view('admin.roles.edit', compact('role', 'permissionParents', 'permissionIds'));
    }

    function update(RoleRequest $request, $id)
    {
        $role = Role::find($id);
        $role->update([
            'name' => $request->name,
            'desc' => $request->desc,
        ]);

        $role->permissions()->sync($request->permission_id);
        return redirect()->route('role.list')->with('status', 'Cập nhật nhóm quyền thành công');
    }

    function delete($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect()->back()->with('status', 'Xóa tạm thời thành công');
    }

    function action(Request $request)
    {
        $listCheck = $request->listCheck;
        $act = $request->act;
        if ($listCheck) {
            if ($act) {
                if ($act == 'delete') {
                    Role::destroy($listCheck);
                    return redirect()->route('role.list')->with('status', 'Bạn đã xóa tạm thời thành công');
                }

                if ($act == "restore") {
                    Role::onlyTrashed()->whereIn('id',$listCheck)->restore();
                    return redirect()->route('role.list')->with('status', 'Bạn đã khôi phục thành công');
                }

                if ($act == "forceDelete") {
                    
                    $roles =  Role::onlyTrashed()->whereIn('id', $listCheck)->get();
                    foreach($roles as $role){
                        $role->permissions()->detach();
                        $role->forceDelete();
                    }
                    
                    return redirect()->route('role.list')->with('status', 'Bạn đã xóa vĩnh viễn thành công');
                }
            } else {
                return redirect()->back()->with('error', 'Bạn cần chọn tác vụ để thực hiện');
            }
        } else {
            return redirect()->back()->with('error', 'Bạn chưa chọn bản ghi để thực hiện');
        }
    }
}
