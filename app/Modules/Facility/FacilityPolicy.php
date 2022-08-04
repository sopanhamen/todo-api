<?php

namespace App\Modules\Facility;

use App\Modules\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Modules\Permission\Enum\Permission;

class FacilityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Facility.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // return $user->can(Permission::VIEW_FACILITY);
        return true;
    }

    /**
     * Determine whether the user can view the Facility.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return $user->can(Permission::VIEW_FACILITY->value);
    }

    /**
     * Determine whether the user can create Facility.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can(Permission::CREATE_FACILITY->value);
    }

    /**
     * Determine whether the user can update the Facility.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return $user->can(Permission::UPDATE_FACILITY->value);
    }

    /**
     * Determine whether the user can delete the Facility.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return $user->can(Permission::DELETE_FACILITY->value);
    }

    /**
     * Determine whether the user can restore the Facility.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user)
    {
        return $user->can(Permission::DELETE_FACILITY->value);
    }

    /**
     * Determine whether the user can permanently delete the Facility.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        return $user->can(Permission::DELETE_FACILITY->value);
    }

    /**
     * Determine whether the user can export the Facility.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function export(User $user)
    {
        return $user->can(Permission::VIEW_FACILITY->value);
    }
}
