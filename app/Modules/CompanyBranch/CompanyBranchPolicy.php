<?php

namespace App\Modules\CompanyBranch;

use App\Modules\Company\Company;
use App\Modules\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Modules\Permission\Enum\Permission;

class CompanyBranchPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Company Branch.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can(Permission::VIEW_ANY_COMPANY_BRANCH);
    }

    /**
     * Determine whether the user can view the Company Branch.
     *
     * @param  \App\Modules\User\User  $user
     * @param  \App\Modules\CompanyBranch\CompanyBranch  $companyBranch
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, CompanyBranch $companyBranch)
    {
        return ($user->can(Permission::VIEW_COMPANY_BRANCH) && $companyBranch->created_by === $user->id)
            || $user->can(Permission::VIEW_ANY_COMPANY_BRANCH);
    }

    /**
     * Determine whether the user can create Company Branch.
     *
     * @param  \App\Modules\User\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Company $company)
    {
        return $user->can(Permission::CREATE_COMPANY_BRANCH)
            || $user->can(Permission::CREATE_ANY_COMPANY_BRANCH);
    }

    /**
     * Determine whether the user can update the Company Branch.
     *
     * @param  \App\Modules\User\User  $user
     * @param  \App\Modules\CompanyBranch\CompanyBranch  $companyBranch
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, CompanyBranch $companyBranch)
    {
        return ($user->can(Permission::UPDATE_COMPANY_BRANCH) && $companyBranch->created_by === $user->id)
            || $user->can(Permission::UPDATE_ANY_COMPANY_BRANCH);
    }

    /**
     * Determine whether the user can delete the CompanyBranch.
     *
     * @param  \App\Modules\User\User  $user
     * @param  \App\Modules\CompanyBranch\CompanyBranch  $companyBranch
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, CompanyBranch $companyBranch)
    {
        return ($user->can(Permission::DELETE_COMPANY_BRANCH) && $companyBranch->created_by === $user->id)
            || $user->can(Permission::DELETE_ANY_COMPANY_BRANCH);
    }

    /**
     * Determine whether the user can restore the CompanyBranch.
     *
     * @param  \App\Modules\User\User  $user
     * @param  \App\Modules\CompanyBranch\CompanyBranch  $companyBranch
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, CompanyBranch $companyBranch)
    {
        return ($user->can(Permission::DELETE_COMPANY_BRANCH) && $companyBranch->created_by === $user->id)
            || $user->can(Permission::DELETE_ANY_COMPANY_BRANCH);
    }

    /**
     * Determine whether the user can permanently delete the CompanyBranch.
     *
     * @param  \App\Modules\User\User  $user
     * @param  \App\Modules\CompanyBranch\CompanyBranch  $companyBranch
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, CompanyBranch $companyBranch)
    {
        return ($user->can(Permission::DELETE_COMPANY_BRANCH) && $companyBranch->created_by === $user->id)
            || $user->can(Permission::DELETE_ANY_COMPANY_BRANCH);
    }
}
