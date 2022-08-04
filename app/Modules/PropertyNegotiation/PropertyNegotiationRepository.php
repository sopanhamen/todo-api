<?php

namespace App\Modules\PropertyNegotiation;

use App\Libraries\Crud\CrudRepository;
use App\Modules\PropertyNegotiation\PropertyNegotiation;

class PropertyNegotiationRepository extends CrudRepository
{
    public function __construct(PropertyNegotiation $propertyNegotiation)
    {
        parent::__construct($propertyNegotiation);
    }
}
