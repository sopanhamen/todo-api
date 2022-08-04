<?php

namespace App\Modules\Property;

use App\Modules\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Modules\Permission\Enum\Permission;
use App\Modules\User\UserService;

class PropertyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Property.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can(Permission::VIEW_PROPERTY->value);
    }

    /**
     * Determine whether the user can view the Property.
     *
     * @param  \App\Modules\User\User  $user
     * @param  \App\Modules\Property\Property  $property
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Property $property)
    {
        return $user->can(Permission::VIEW_PROPERTY->value);
    }

    /**
     * Determine whether the user can view the Property documents.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewDocument(User $user, Property $property)
    {
        if ($user->can(Permission::VIEW_PROPERTY->value) && $this->isOwner($user, $property)) {
            return true;
        }

        if ($user->can(Permission::VIEW_ANY_PROPERTY_DOCUMENT->value)) {
            return true;
        }

        if ($user->can(Permission::VIEW_COMPANY_PROPERTY_DOCUMENT->value)) {
            return true;
        }

        if ($user->can(Permission::VIEW_BRANCH_PROPERTY_DOCUMENT->value)) {
            return true;
        }

        if ($user->can(Permission::VIEW_TEAM_PROPERTY_DOCUMENT->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the Property sale contact.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewSaleContact(User $user, Property $property)
    {
        if ($user->can(Permission::VIEW_PROPERTY->value) && $this->isOwner($user, $property)) {
            return true;
        }

        if ($user->can(Permission::VIEW_ANY_PROPERTY_SALE_CONTACT->value)) {
            return true;
        }

        $userProfile = UserService::basicProfile($user);

        if ($user->can(Permission::VIEW_COMPANY_PROPERTY_SALE_CONTACT->value)) {
            return $property->company_id === $userProfile->company_id;
        }

        if ($user->can(Permission::VIEW_BRANCH_PROPERTY_SALE_CONTACT->value)) {
            return $property->company_branch_id === $userProfile->company_branch_id;
        }

        if ($user->can(Permission::VIEW_TEAM_PROPERTY_SALE_CONTACT->value)) {
            return $userProfile->teams->pluck('id')->contains($property->team_id);
        }

        return false;
    }

    /**
     * Determine whether the user can view the Property owner contact.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewOwnerContact(User $user, Property $property)
    {
        if ($user->can(Permission::VIEW_PROPERTY->value) && $this->isOwner($user, $property)) {
            return true;
        }

        if ($user->can(Permission::VIEW_ANY_PROPERTY_OWNER_CONTACT->value)) {
            return true;
        }

        $userProfile = UserService::basicProfile($user);

        if ($user->can(Permission::VIEW_COMPANY_PROPERTY_OWNER_CONTACT->value)) {
            return $property->company_id === $userProfile->company_id;
        }

        if ($user->can(Permission::VIEW_BRANCH_PROPERTY_OWNER_CONTACT->value)) {
            return $property->company_branch_id === $userProfile->company_branch_id;
        }

        if ($user->can(Permission::VIEW_TEAM_PROPERTY_OWNER_CONTACT->value)) {
            return $userProfile->teams->pluck('id')->contains($property->team_id);
        }

        return false;
    }

    /**
     * Determine whether the user can create Property.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if ($user->can(Permission::CREATE_ANY_PROPERTY->value)) {
            return true;
        }

        if ($user->can(Permission::CREATE_COMPANY_PROPERTY->value)) {
            return true;
        }

        if ($user->can(Permission::CREATE_BRANCH_PROPERTY->value)) {
            return true;
        }

        if ($user->can(Permission::CREATE_TEAM_PROPERTY->value)) {
            return true;
        }

        return $user->can(Permission::CREATE_PROPERTY->value);
    }

    /**
     * Determine whether the user can update the Property.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        // return $user->can(Permission::UPDATE_USER->value);
        return true;
    }

    /**
     * Determine whether the user can delete the Property.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        // return $user->can(Permission::DELETE_USER->value);
        return true;
    }

    /**
     * Determine whether the user can restore the Property.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user)
    {
        // return $user->can(Permission::RESTORE_USER->value);
        return true;
    }

    /**
     * Determine whether the user can permanently delete the Property.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        // return $user->can(Permission::FORCE_DELETE_USER->value);
        return true;
    }

    /**
     * @param User $user
     * @param Property $property
     * @return bool
     */
    private function isOwner(User $user, Property $property): bool
    {
        return $user->id === $property->assignor_id ||  $user->id === $property->assignee_id;
    }

    /**
     * Determine whether the user can approve the Property.
     *
     * @param  \App\Modules\User\User  $user
     * @param  \App\Modules\Property\Property  $property
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function approve(User $user, Property $property)
    {
        if ($user->can(Permission::APPROVE_ANY_LISTING->value)) {
            return true;
        }

        $userProfile = UserService::basicProfile($user);
        if ($user->can(Permission::APPROVE_COMPANY_LISTING->value)) {
            return $property->company_id === $userProfile->company_id;
        }


        if ($user->can(Permission::APPROVE_BRANCH_LISTING->value)) {
            return $property->company_branch_id === $userProfile->company_branch_id;
        }

        if ($user->can(Permission::APPROVE_TEAM_LISTING->value)) {
            return $userProfile->teams->pluck('id')->contains($property->team_id);
        }

        return false;
    }

    /**
     * Determine whether the user can create Property.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function transfer(User $user)
    {
        if ($user->can(Permission::TRANSFER_TEAM_PROPERTY->value)) {
            return true;
        }

        if ($user->can(Permission::TRANSFER_BRANCH_PROPERTY->value)) {
            return true;
        }

        if ($user->can(Permission::TRANSFER_COMPANY_PROPERTY->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can publish the Property.
     *
     * @param  \App\Modules\User\User  $user
     * @param  \App\Modules\Property\Property  $property
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function publish(User $user, Property $property)
    {
        $userProfile = UserService::basicProfile($user);
        if ($user->can(Permission::PUBLISH_COMPANY_LISTING->value)) {
            return $property->company_id === $userProfile->company_id;
        }

        $userProfile = UserService::basicProfile($user);
        if ($user->can(Permission::PUBLISH_BRANCH_LISTING->value)) {
            return $property->company_branch_id === $userProfile->company_branch_id;
        }

        if ($user->can(Permission::PUBLISH_TEAM_LISTING->value)) {
            return $userProfile->teams->pluck('id')->contains($property->team_id);
        }

        return false;
    }
}
