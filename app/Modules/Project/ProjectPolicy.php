<?php

namespace App\Modules\Project;

use App\Modules\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Modules\Permission\Enum\Permission;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $loggedUser)
    {
        return $loggedUser->can(Permission::VIEW_PROJECT->value);
    }

    /**
     * Determine whether the user can view the project.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $loggedUser)
    {
        return $loggedUser->can(Permission::VIEW_PROJECT->value);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $loggedUser)
    {
        return $loggedUser->can(Permission::CREATE_PROJECT->value);
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $loggedUser)
    {
        return $loggedUser->can(Permission::UPDATE_PROJECT->value);
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $loggedUser)
    {
        return $loggedUser->can(Permission::DELETE_PROJECT->value);
    }

    /**
     * Determine whether the user can restore the project.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $loggedUser)
    {
        return $loggedUser->can(Permission::DELETE_PROJECT->value);
    }

    /**
     * Determine whether the user can permanently delete the project.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $loggedUser)
    {
        return $loggedUser->can(Permission::DELETE_PROJECT->value);
    }

    /**
     * Determine whether the user can export the project.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function export(User $loggedUser)
    {
        return $loggedUser->can(Permission::VIEW_PROJECT->value);
    }
}
