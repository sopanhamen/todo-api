<?php

namespace App\Modules\Country;

use App\Libraries\Crud\CrudRepository;
use App\Modules\Country\Country;

class CountryRepository extends CrudRepository
{
    public function __construct(Country $country)
    {
        parent::__construct($country);
    }
}
