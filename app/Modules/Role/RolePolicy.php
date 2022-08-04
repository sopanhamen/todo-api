<?php

namespace App\Modules\Role;

use App\Modules\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Modules\Permission\Enum\Permission;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view roles.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
        // return $user->can(Permission::VIEW_ROLE->value);
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return $user->can(Permission::VIEW_ROLE->value);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can(Permission::CREATE_ROLE->value);
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return $user->can(Permission::UPDATE_ROLE->value);
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return $user->can(Permission::DELETE_ROLE->value);
    }

    /**
     * Determine whether the user can restore the role.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user)
    {
        return $user->can(Permission::DELETE_ROLE->value);
    }

    /**
     * Determine whether the user can permanently delete the role.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        return $user->can(Permission::DELETE_ROLE->value);
    }
}
