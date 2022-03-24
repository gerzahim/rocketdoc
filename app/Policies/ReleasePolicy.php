<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Release;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReleasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the release can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list releases');
    }

    /**
     * Determine whether the release can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Release  $model
     * @return mixed
     */
    public function view(User $user, Release $model)
    {
        return $user->hasPermissionTo('view releases');
    }

    /**
     * Determine whether the release can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create releases');
    }

    /**
     * Determine whether the release can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Release  $model
     * @return mixed
     */
    public function update(User $user, Release $model)
    {
        return $user->hasPermissionTo('update releases');
    }

    /**
     * Determine whether the release can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Release  $model
     * @return mixed
     */
    public function delete(User $user, Release $model)
    {
        return $user->hasPermissionTo('delete releases');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Release  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete releases');
    }

    /**
     * Determine whether the release can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Release  $model
     * @return mixed
     */
    public function restore(User $user, Release $model)
    {
        return false;
    }

    /**
     * Determine whether the release can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Release  $model
     * @return mixed
     */
    public function forceDelete(User $user, Release $model)
    {
        return false;
    }
}
