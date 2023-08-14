<?php

namespace App\Policies;

use App\Slider;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SliderPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Slider  $slider
     * @return mixed
     */
    public function view(User $user, Slider $slider)
    {
        $permissions = 0;
        foreach ($user->roles as $role) {
            $permissions += count($role->permissions);
        }
        // dd($permissions);
        if (($user->checkPermissionAccess('list_slider') && $slider->user_id == $user->id) || $permissions == 32) {
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
     * @param  \App\Slider  $slider
     * @return mixed
     */
    public function update(User $user)
    {
        if ($user->checkPermissionAccess('edit_slider')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Slider  $slider
     * @return mixed
     */
    public function delete(User $user)
    {
        if ($user->checkPermissionAccess('delete_slider')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Slider  $slider
     * @return mixed
     */
    public function restore(User $user, Slider $slider)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Slider  $slider
     * @return mixed
     */
    public function forceDelete(User $user, Slider $slider)
    {
        //
    }
}
