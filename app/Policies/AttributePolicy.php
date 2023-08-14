<?php

namespace App\Policies;

use App\Attribute;
use App\AttributeValue;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttributePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Attribute  $attribute
     * @return mixed
     */
    public function view(User $user, Attribute $attribute)
    {
        $permissions = 0;
        foreach ($user->roles as $role) {
            $permissions += count($role->permissions);
        }
        // dd($permissions);
        if (($user->checkPermissionAccess('list_attribute') && $attribute->user_id == $user->id) || $permissions >= 32) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Attribute  $attribute
     * @return mixed
     */
    public function update(User $user)
    {
        if ($user->checkPermissionAccess('edit_attribute')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Attribute  $attribute
     * @return mixed
     */
    public function delete(User $user)
    {
        if ($user->checkPermissionAccess('delete_attribute')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Attribute  $attribute
     * @return mixed
     */
    public function restore(User $user, Attribute $attribute)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Attribute  $attribute
     * @return mixed
     */
    public function forceDelete(User $user, Attribute $attribute)
    {
        //
    }

    // mục đích showAttributeValue là để mỗi user nào đăng nhập vào hệ thống thì chỉ thấy được bản ghi do mình tạo ra, còn user đó không thể thấy được bản ghi của người khác 
    public function showAttributeValue(User $user, Attribute $attribute)
    {
        $permissions = 0;
        foreach ($user->roles as $role) {
            $permissions += count($role->permissions);
        }
        if (($user->checkPermissionAccess('list_attribute') && $attribute->user_id == $user->id) || $permissions == 32) {
            return true;
        }
        return false;
    }
}
