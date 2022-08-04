<?php

namespace App\Modules\PropertyVisit;

use App\Libraries\Crud\CrudRepository;
use App\Modules\PropertyVisit\PropertyVisit;

class PropertyVisitRepository extends CrudRepository
{
    public function __construct(PropertyVisit $propertyVisit)
    {
        parent::__construct($propertyVisit);
    }
}
