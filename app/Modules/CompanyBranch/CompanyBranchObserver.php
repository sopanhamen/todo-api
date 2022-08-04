<?php

namespace App\Modules\CompanyBranch;

use App\Modules\CompanyBranch\CompanyBranch;
use App\Modules\UserTeam\UserTeamService;

class CompanyBranchObserver
{
    public $afterCommit = true;

    private UserTeamService $userTeamService;

    public function __construct(UserTeamService $userTeamService)
    {
        $this->userTeamService = $userTeamService;
    }

    /**
     * Handle the CompanyBranch "created" event.
     *
     * @param  \App\Modules\CompanyBranch\CompanyBranch  $companyBranch
     * @return void
     */
    public function created(CompanyBranch $companyBranch)
    {
        $this->userTeamService->createDefaultTeam($companyBranch);
    }

    /**
     * Handle the CompanyBranch "updated" event.
     *
     * @param  \App\Modules\CompanyBranch\CompanyBranch  $companyBranch
     * @return void
     */
    public function updated(CompanyBranch $companyBranch)
    {
        //
    }

    /**
     * Handle the CompanyBranch "deleted" event.
     *
     * @param  \App\Modules\CompanyBranch\CompanyBranch  $companyBranch
     * @return void
     */
    public function deleted(CompanyBranch $companyBranch)
    {
        //
    }

    /**
     * Handle the CompanyBranch "restored" event.
     *
     * @param  \App\Modules\CompanyBranch\CompanyBranch  $companyBranch
     * @return void
     */
    public function restored(CompanyBranch $companyBranch)
    {
        //
    }

    /**
     * Handle the CompanyBranch "force deleted" event.
     *
     * @param  \App\Modules\CompanyBranch\CompanyBranch  $companyBranch
     * @return void
     */
    public function forceDeleted(CompanyBranch $companyBranch)
    {
        //
    }
}
