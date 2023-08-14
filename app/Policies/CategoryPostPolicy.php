<?php

namespace App\Policies;

use App\CategoryPost;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPostPolicy
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

    function showCategoryPost(User $user,CategoryPost $catPost){
        $permissions = 0;
        foreach($user->roles as $role){
            $permissions += count($role->permissions);
        }
        // dd($permissions);
        if (($user->checkPermissionAccess('list_post') && $catPost->user_id == $user->id) || $permissions >= 32) {
            return true;
        }
        return false;
    }
}
