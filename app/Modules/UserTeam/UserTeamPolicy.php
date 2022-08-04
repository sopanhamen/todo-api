<?php

namespace App\Modules\UserTeam;

use App\Modules\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Modules\Permission\Enum\Permission;

class UserTeamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any User.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // return $user->can(Permission::VIEW_USER);
        return true;
    }

    /**
     * Determine whether the user can view the User.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        if ($user->can(Permission::VIEW_BRANCH_TEAM->value)) {
            return true;
        }

        if ($user->can(Permission::VIEW_COMPANY_TEAM->value)) {
            return true;
        }

        if ($user->can(Permission::VIEW_ANY_TEAM->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create Client.
     *
     * @param  \App\Modules\User\User  $userTeam
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {

        if ($user->can(Permission::CREATE_COMPANY_TEAM->value)) {
            return true;
        }

        if ($user->can(Permission::CREATE_BRANCH_TEAM->value)) {
            return true;
        }

        if ($user->can(Permission::CREATE_ANY_TEAM->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the User.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        if ($user->can(Permission::UPDATE_BRANCH_TEAM->value)) {
            return true;
        }

        if ($user->can(Permission::UPDATE_COMPANY_TEAM->value)) {
            return true;
        }

        if ($user->can(Permission::UPDATE_ANY_TEAM->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the User.
     *
     * @param  \App\Modules\User\User  $userTeam
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        if ($user->can(Permission::DELETE_BRANCH_TEAM->value)) {
            return true;
        }

        if ($user->can(Permission::DELETE_COMPANY_TEAM->value)) {
            return true;
        }

        if ($user->can(Permission::DELETE_ANY_TEAM->value)) {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can restore the Client.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user)
    {
        if ($user->can(Permission::DELETE_BRANCH_TEAM->value)) {
            return true;
        }

        if ($user->can(Permission::DELETE_COMPANY_TEAM->value)) {
            return true;
        }

        if ($user->can(Permission::DELETE_ANY_TEAM->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the Client.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        if ($user->can(Permission::DELETE_BRANCH_TEAM->value)) {
            return true;
        }

        if ($user->can(Permission::DELETE_COMPANY_TEAM->value)) {
            return true;
        }

        if ($user->can(Permission::DELETE_ANY_TEAM->value)) {
            return true;
        }

        return false;
    }
}
