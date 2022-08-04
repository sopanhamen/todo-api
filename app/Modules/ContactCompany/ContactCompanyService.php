<?php

namespace App\Modules\ContactCompany;

use App\Libraries\Crud\CrudService;

class ContactCompanyService extends CrudService
{
    protected array $allowedRelations = [];

    public function __construct(ContactCompanyRepository $repo)
    {
        parent::__construct($repo);
    }
}
