<?php

namespace App\Modules\UserProfile;

use App\Modules\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Modules\Permission\Enum\Permission;

class UserProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the User Profile.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return $user->can(Permission::VIEW_USER);
    }

    /**
     * Determine whether the user can create User Profile.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can(Permission::CREATE_USER);
    }

    /**
     * Determine whether the user can update the User Profile.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return $user->can(Permission::UPDATE_USER);
    }

    /**
     * Determine whether the user can delete the UserProfile.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return $user->can(Permission::DELETE_USER);
    }

    /**
     * Determine whether the user can restore the UserProfile.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user)
    {
        return $user->can(Permission::RESTORE_USER);
    }

    /**
     * Determine whether the user can permanently delete the UserProfile.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        return $user->can(Permission::FORCE_DELETE_USER);
    }
}
