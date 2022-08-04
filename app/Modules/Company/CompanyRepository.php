<?php

namespace App\Modules\Company;

use App\Libraries\Crud\CrudRepository;
use App\Modules\Company\Company;

class CompanyRepository extends CrudRepository
{
    public function __construct(Company $company)
    {
        parent::__construct($company);
    }

    public function getOneCompany(): ?Company
    {
        return $this->model->first();
    }
}