<?php

namespace App\Modules\ContactCompany;

use App\Libraries\Crud\CrudRepository;
use App\Modules\ContactCompany\ContactCompany;

class ContactCompanyRepository extends CrudRepository
{
    public function __construct(ContactCompany $contactCompany)
    {
        parent::__construct($contactCompany);
    }
}
