<?php

namespace App\Modules\Facility;

use App\Libraries\Crud\CrudRepository;
use App\Modules\Facility\Facility;

class FacilityRepository extends CrudRepository
{
    public function __construct(Facility $facility)
    {
        parent::__construct($facility);
    }
}
