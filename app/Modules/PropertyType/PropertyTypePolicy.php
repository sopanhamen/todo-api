<?php

namespace App\Modules\PropertyType;

use App\Modules\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Modules\Permission\Enum\Permission;

class PropertyTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the property-type.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $loggedUser)
    {
        return $loggedUser->can(Permission::VIEW_PROPERTY_TYPE->value);
    }

    /**
     * Determine whether the user can view the property-type.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $loggedUser)
    {
        return $loggedUser->can(Permission::VIEW_PROPERTY_TYPE->value);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $loggedUser)
    {
        return $loggedUser->can(Permission::CREATE_PROPERTY_TYPE->value);
    }

    /**
     * Determine whether the user can update the property-type.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $loggedUser)
    {
        return $loggedUser->can(Permission::UPDATE_PROPERTY_TYPE->value);
    }

    /**
     * Determine whether the user can delete the property-type.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $loggedUser)
    {
        return $loggedUser->can(Permission::DELETE_PROPERTY_TYPE->value);
    }

    /**
     * Determine whether the user can restore the property-type.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $loggedUser)
    {
        return $loggedUser->can(Permission::DELETE_PROPERTY_TYPE->value);
    }

    /**
     * Determine whether the user can permanently delete the property-type.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $loggedUser)
    {
        return $loggedUser->can(Permission::DELETE_PROPERTY_TYPE->value);
    }

    /**
     * Determine whether the user can export the property-type.
     *
     * @param  \App\Modules\User\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function export(User $loggedUser)
    {
        return $loggedUser->can(Permission::VIEW_PROPERTY_TYPE->value);
    }
}
