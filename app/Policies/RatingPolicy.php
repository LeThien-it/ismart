<?php

namespace App\Policies;

use App\Rating;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RatingPolicy
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
     * @param  \App\Rating  $rating
     * @return mixed
     */
    public function view(User $user, Rating $rating)
    {
        //
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
     * @param  \App\Rating  $rating
     * @return mixed
     */
    public function update(User $user)
    {
        if ($user->checkPermissionAccess('edit_rating')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Rating  $rating
     * @return mixed
     */
    public function delete(User $user)
    {
        if ($user->checkPermissionAccess('delete_rating')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Rating  $rating
     * @return mixed
     */
    public function restore(User $user, Rating $rating)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Rating  $rating
     * @return mixed
     */
    public function forceDelete(User $user, Rating $rating)
    {
        //
    }
}
