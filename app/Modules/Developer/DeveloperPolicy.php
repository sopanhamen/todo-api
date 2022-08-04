<?php

namespace App\Modules\Developer;

use App\Modules\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Modules\Permission\Enum\Permission;

class DeveloperPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the developer.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $loggedUser)
    {
        return $loggedUser->can(Permission::VIEW_DEVELOPER->value);
    }

    /**
     * Determine whether the user can view the developer.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $loggedUser)
    {
        return $loggedUser->can(Permission::VIEW_DEVELOPER->value);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $loggedUser)
    {
        return $loggedUser->can(Permission::CREATE_DEVELOPER->value);
    }

    /**
     * Determine whether the user can update the developer.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $loggedUser)
    {
        return $loggedUser->can(Permission::UPDATE_DEVELOPER->value);
    }

    /**
     * Determine whether the user can delete the developer.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $loggedUser)
    {
        return $loggedUser->can(Permission::DELETE_DEVELOPER->value);
    }

    /**
     * Determine whether the user can restore the developer.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $loggedUser)
    {
        return $loggedUser->can(Permission::DELETE_DEVELOPER->value);
    }

    /**
     * Determine whether the user can permanently delete the developer.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $loggedUser)
    {
        return $loggedUser->can(Permission::DELETE_DEVELOPER->value);
    }

    /**
     * Determine whether the user can export the developer.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function export(User $loggedUser)
    {
        return $loggedUser->can(Permission::VIEW_DEVELOPER->value);
    }
}
