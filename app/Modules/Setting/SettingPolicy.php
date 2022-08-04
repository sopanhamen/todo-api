<?php

namespace App\Modules\Setting;

use App\Modules\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Modules\Permission\Enum\Permission;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Setting.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the Setting.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the Setting.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return $user->can(Permission::UPDATE_GENERAL_SETTING->value);
    }

    /**
     * Determine whether the user can delete the Setting.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return $user->can(Permission::UPDATE_GENERAL_SETTING->value);
    }
}
