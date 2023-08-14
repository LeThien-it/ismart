<?php

namespace App\Policies;

use App\CategoryProduct;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryProductPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    function showCategoryProduct(User $user,CategoryProduct $catPro){
        $permissions = 0;
        foreach($user->roles as $role){
            $permissions += count($role->permissions);
        }
        // dd($permissions);
        if (($user->checkPermissionAccess('list_product') && $catPro->user_id == $user->id) || $permissions >= 32) {
            return true;
        }
        return false;
    }
}
