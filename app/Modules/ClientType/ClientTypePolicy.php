<?php

namespace App\Modules\ClientType;

use App\Modules\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Modules\Permission\Enum\Permission;

class ClientTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the client-type.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $loggedUser)
    {
        return $loggedUser->can(Permission::VIEW_CLIENT_TYPE->value);
    }

    /**
     * Determine whether the user can view the client-type.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $loggedUser)
    {
        return $loggedUser->can(Permission::VIEW_CLIENT_TYPE->value);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $loggedUser)
    {
        return $loggedUser->can(Permission::CREATE_CLIENT_TYPE->value);
    }

    /**
     * Determine whether the user can update the client-type.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $loggedUser)
    {
        return $loggedUser->can(Permission::UPDATE_CLIENT_TYPE->value);
    }

    /**
     * Determine whether the user can delete the client-type.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $loggedUser)
    {
        return $loggedUser->can(Permission::DELETE_CLIENT_TYPE->value);
    }

    /**
     * Determine whether the user can restore the client-type.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $loggedUser)
    {
        return $loggedUser->can(Permission::DELETE_CLIENT_TYPE->value);
    }

    /**
     * Determine whether the user can permanently delete the client-type.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $loggedUser)
    {
        return $loggedUser->can(Permission::DELETE_CLIENT_TYPE->value);
    }

    /**
     * Determine whether the user can export the client-type.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function export(User $loggedUser)
    {
        return $loggedUser->can(Permission::VIEW_CLIENT_TYPE->value);
    }
}
