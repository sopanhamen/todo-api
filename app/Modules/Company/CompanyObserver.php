<?php

namespace App\Modules\Company;

use App\Modules\Company\Company;
use App\Modules\CompanyBranch\CompanyBranchService;

class CompanyObserver
{
    public $afterCommit = true;

    private CompanyBranchService $companyBranchService;

    public function __construct(CompanyBranchService $companyBranchService)
    {
        $this->companyBranchService = $companyBranchService;
    }

    /**
     * Handle the Company "created" event.
     *
     * @param  \App\Modules\Company\Company  $company
     * @return void
     */
    public function created(Company $company)
    {
        $this->companyBranchService->createDefaultBranch($company);
    }

    /**
     * Handle the Company "updated" event.
     *
     * @param  \App\Modules\Company\Company  $company
     * @return void
     */
    public function updated(Company $company)
    {
        //
    }

    /**
     * Handle the Company "deleted" event.
     *
     * @param  \App\Modules\Company\Company  $company
     * @return void
     */
    public function deleted(Company $company)
    {
        //
    }

    /**
     * Handle the Company "restored" event.
     *
     * @param  \App\Modules\Company\Company  $company
     * @return void
     */
    public function restored(Company $company)
    {
        //
    }

    /**
     * Handle the Company "force deleted" event.
     *
     * @param  \App\Modules\Company\Company  $company
     * @return void
     */
    public function forceDeleted(Company $company)
    {
        //
    }
}
