<?php

namespace App\Modules\District;

use App\Libraries\Crud\CrudRepository;
use App\Modules\District\District;

class DistrictRepository extends CrudRepository
{
    public function __construct(District $district)
    {
        parent::__construct($district);
    }
}
