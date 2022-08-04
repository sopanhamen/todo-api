<?php

namespace App\Modules\User;

use App\Modules\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Modules\Permission\Enum\Permission;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view users.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        if ($user->can(Permission::VIEW_ANY_USER->value)) {
            return true;
        }

        if ($user->can(Permission::VIEW_COMPANY_USER->value)) {
            return true;
        }

        if ($user->can(Permission::VIEW_BRANCH_USER->value)) {
            return true;
        }

        if ($user->can(Permission::VIEW_TEAM_USER->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\Modules\User\User  $user
     * @param  \App\Modules\User\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        if ($user->can(Permission::VIEW_ANY_USER->value)) {
            return true;
        }

        if ($user->can(Permission::VIEW_COMPANY_USER->value)) {
            return true;
        }

        if ($user->can(Permission::VIEW_BRANCH_USER->value)) {
            return true;
        }

        if ($user->can(Permission::VIEW_TEAM_USER->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Modules\User\User  $user
     * @param  \App\Modules\User\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if ($user->can(Permission::CREATE_ANY_USER->value)) {
            return true;
        }

        if ($user->can(Permission::CREATE_COMPANY_USER->value)) {
            return true;
        }

        if ($user->can(Permission::CREATE_BRANCH_USER->value)) {
            return true;
        }

        if ($user->can(Permission::CREATE_TEAM_USER->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\Modules\User\User  $user
     * @param  \App\Modules\User\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        if ($user->can(Permission::UPDATE_ANY_USER->value)) {
            return true;
        }

        if ($user->can(Permission::UPDATE_COMPANY_USER->value)) {
            return true;
        }

        if ($user->can(Permission::UPDATE_BRANCH_USER->value)) {
            return true;
        }

        if ($user->can(Permission::UPDATE_TEAM_USER->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\Modules\User\User  $user
     * @param  \App\Modules\User\User  $deletingUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $deletingUser)
    {
        if ($user->can(Permission::DELETE_ANY_USER->value)) {
            return true;
        }

        if ($user->can(Permission::DELETE_COMPANY_USER->value)) {
            return true;
        }

        if ($user->can(Permission::DELETE_BRANCH_USER->value)) {
            return true;
        }

        if ($user->can(Permission::DELETE_TEAM_USER->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the user.
     *
     * @param  \App\Modules\User\User  $user
     * @param  \App\Modules\User\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user)
    {
        if ($user->can(Permission::DELETE_ANY_USER->value)) {
            return true;
        }

        if ($user->can(Permission::DELETE_COMPANY_USER->value)) {
            return true;
        }

        if ($user->can(Permission::DELETE_BRANCH_USER->value)) {
            return true;
        }

        if ($user->can(Permission::DELETE_TEAM_USER->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the user.
     *
     * @param  \App\Modules\User\User  $user
     * @param  \App\Modules\User\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        if ($user->can(Permission::DELETE_ANY_USER->value)) {
            return true;
        }

        if ($user->can(Permission::DELETE_COMPANY_USER->value)) {
            return true;
        }

        if ($user->can(Permission::DELETE_BRANCH_USER->value)) {
            return true;
        }

        if ($user->can(Permission::DELETE_TEAM_USER->value)) {
            return true;
        }

        return false;
    }
}
